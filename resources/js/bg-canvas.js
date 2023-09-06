const debug = false;

const dd = (...log) => debug ? console.log(log) : null;

/** @type {HTMLCanvasElement} */
let canvas;

/** @type {CanvasRenderingContext2D} */
let context;

// Global context to start / stop animation
window.bgCanvasPlaying = true;

// Create points per 1086720px screen area
const pointCountAreaRatio = 200 / 1086720;
const canvasRescale = .1;

// Expected length of 1 frame
const frameTime = 1000 / 60;
let prevFrame = 0;
let points = [];

// Amount that a point can escape the canvas by
const pointPadding = 200 * canvasRescale;
const halfPointPadding = pointPadding / 2;

// Max distance at which a point will line towards a neighbour
const pointDistance = 150 * canvasRescale;
const pointDistanceSquared = pointDistance * pointDistance;
const connectionOverreach = pointDistanceSquared * 1.4;

let darkMode = false;

function bgCanvas() {
    // Track dark mode
    darkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (window.matchMedia) {
        window
            .matchMedia('(prefers-color-scheme: dark)')
            .addEventListener('change', event => darkMode = event.matches);
    }

    // Prep canvas + context
    canvas = document.getElementById('bg-canvas');
    context = canvas.getContext('2d');

    // Resize to the window
    window.addEventListener('resize', resize, { passive: true });
    resize();

    // Start it up
    requestAnimationFrame(step);
}

function step(frame = 0) {
    if (window.bgCanvasPlaying) {
        requestAnimationFrame(step);
    }

    if (frame - prevFrame < frameTime) {
        return;
    }

    let delta = frame - prevFrame;
    prevFrame = frame;

    if (delta > 1000) {
        return;
    }

    for (let i = 0; i < points.length; i++) {
        const point = points[i];

        point.neighbourDist = 0;
        point.neighbourCount = 0;
    }

    // Update point positions
    for (let i = 0; i < points.length; i++) {
        const point = points[i];

        for (let j = i + 1; j < points.length; j++) {
            const neighbour = points[j];

            const distanceSquared = pythag(point, neighbour);

            if (distanceSquared > pointDistanceSquared) {
                continue;
            }

            point.neighbourCount++;
            neighbour.neighbourCount++;

            point.neighbourDist += 1 - (distanceSquared / pointDistanceSquared);
            neighbour.neighbourDist += 1 - (distanceSquared / pointDistanceSquared);

            point.xVelocity += ((point.x - neighbour.x) / pointDistance) / 10;
            point.yVelocity += ((point.y - neighbour.y) / pointDistance) / 10;

            neighbour.xVelocity += ((neighbour.x - point.x) / pointDistance) / 10;
            neighbour.yVelocity += ((neighbour.y - point.y) / pointDistance) / 10;
        }
    }

    for (let i = 0; i < points.length; i++) {
        const point = points[i];

        // Update position
        point.x += ((point.xVelocity * canvasRescale) / 100) * frameTime;
        point.y += ((point.yVelocity * canvasRescale) / 100) * frameTime;

        // Reflect left / right
        if (point.x < -halfPointPadding || point.x > (canvas.width + halfPointPadding)) {
            point.xVelocity *= -1;

            if (point.x < -halfPointPadding) {
                point.x = -halfPointPadding;
            } else if (point.x > (canvas.width + halfPointPadding)) {
                point.x = canvas.width + halfPointPadding;
            }
        }

        // Reflect top / bottom
        if (point.y < -halfPointPadding || point.y > (canvas.height + halfPointPadding)) {
            point.yVelocity *= -1;

            if (point.y < -halfPointPadding) {
                point.y = -halfPointPadding;
            } else if (point.y > (canvas.height + halfPointPadding)) {
                point.y = canvas.height + halfPointPadding;
            }
        }
    }

    draw();
}

function draw() {
    context.fillStyle = darkMode ? "#FFF" : "#000";
    context.strokeStyle = darkMode ? "#FFF" : "#000";
    context.lineCap = 'round';

    const rgb = `${darkMode ? 255 : 0}, ${darkMode ? 255 : 0}, ${darkMode ? 255 : 0}`;

    context.clearRect(0, 0, canvas.width, canvas.height);

    // Draw connections
    for (let i = 0; i < points.length; i++) {
        const point = points[i];

        for (let j = i + 1; j < points.length; j++) {
            const neighbour = points[j];

            const distanceSquared = pythag(point, neighbour);

            if (distanceSquared > connectionOverreach) {
                continue;
            }

            context.beginPath();
            context.moveTo(point.x, point.y);
            context.lineTo(neighbour.x, neighbour.y);

            context.lineWidth = ((1 - (distanceSquared / connectionOverreach)) * 10) * canvasRescale;
            context.strokeStyle = `rgba(${rgb}, ${1 - (distanceSquared / connectionOverreach)})`;
            context.stroke();
        }
    }

    // Draw points
    for (let i = 0; i < points.length; i++) {
        context.fillStyle = darkMode ? "#FFF" : "#000";
        context.strokeStyle = darkMode ? "#FFF" : "#000";

        const point = points[i];

        context.moveTo(point.x, point.y);
        context.beginPath();
        context.arc(point.x, point.y, (Math.min(10, 1 + (point.neighbourDist * point.neighbourDist) / 2)) * canvasRescale, 0, Math.PI * 2);
        context.closePath();
        context.fill();

        if (debug) {
            context.fillStyle = 'red';
            context.fillText(i, point.x, point.y + 15);
        }
    }
}

function generatePoints() {
    const { width, height } = canvas.getBoundingClientRect();
    const area = width * height;
    const pointCount = Math.round(area * pointCountAreaRatio);

    const availableWidth = canvas.width + pointPadding;
    const availableHeight = canvas.height + pointPadding;

    const rows = 5;
    const cols = Math.floor(pointCount / rows);

    const colDistance = availableWidth / cols;
    const rowDistance = availableHeight / rows;

    if (points.length !== 0) {
        points.length = rows * cols;
    } else {
        points = [];
    }

    let i = 0;

    for (let y = 0; y < rows; y++) {
        for (let x = 0; x < cols; x++) {
            if (points[i] === undefined) {
                points[i] = {
                    x: ((Math.random() - .5) * pointDistance) + (x * colDistance) - halfPointPadding,
                    y: ((Math.random() - .5) * pointDistance) + (y * rowDistance) - halfPointPadding,
                    xVelocity: (Math.random() - .5) / 1000,
                    yVelocity: (Math.random() - .5) / 1000,
                    neighbourCount: 0,
                    neighbourDist: 0,
                };
            }

            i++;
        }
    }
}

function resize() {
    const { width, height } = canvas.getBoundingClientRect();

    canvas.width = width * canvasRescale;
    canvas.height = height * canvasRescale;

    generatePoints();
}

function pythag(p1, p2) {
    const xDiff = Math.abs(p1.x - p2.x);
    const yDiff = Math.abs(p1.y - p2.y);
    return (xDiff * xDiff) + (yDiff * yDiff);
}

export default bgCanvas;
