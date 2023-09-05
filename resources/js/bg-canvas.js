const debug = false;

const dd = (...log) => debug ? console.log(log) : null;

/** @type {HTMLCanvasElement} */
let canvas;

/** @type {CanvasRenderingContext2D} */
let context;

window.bgCanvasPlaying = true;

// Create points per 1086720px screen area
const pointCountAreaRatio = 150 / 1086720;

// Expected length of 1 frame
const frameTime = 1000 / 60;
let prevFrame = 0;
let points = [];

// Amount that a point can escape the canvas by
const pointPadding = 200;
const halfPointPadding = pointPadding / 2;

// Max distance at which a point will line towards a neighbour
const pointDistance = 150;
const pointDistanceSquared = pointDistance * pointDistance;

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
        // console.groupCollapsed('step ' + i);
        const point = points[i];

        point.neighbourDist = 0;
        point.neighbourCount = 0;

        // point.xVelocity *= 0.99;
        // point.yVelocity *= 0.99;
    }

    // Update point positions
    // console.clear();

    for (let i = 0; i < points.length; i++) {
        // console.groupCollapsed('step ' + i);
        const point = points[i];

        for (let j = i + 1; j < points.length; j++) {
            const neighbour = points[j];

            // c2 = x2 + y2
            const xDiff = Math.abs(point.x - neighbour.x);
            const yDiff = Math.abs(point.y - neighbour.y);
            const distanceSquared = (xDiff * xDiff) + (yDiff * yDiff);

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
        // console.groupCollapsed('step ' + i);
        const point = points[i];

        // Update position
        point.x += ((point.xVelocity/*  + ((Math.random() - .5) * 2) */) / 100) * frameTime;
        point.y += ((point.yVelocity/*  + ((Math.random() - .5) * 2) */) / 100) * frameTime;

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


        // console.groupEnd();

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
        // console.groupCollapsed(i);
        const point = points[i];

        for (let j = i + 1; j < points.length; j++) {
            const neighbour = points[j];

            // c2 = x2 + y2
            const xDiff = Math.abs(point.x - neighbour.x);
            const yDiff = Math.abs(point.y - neighbour.y);
            const distanceSquared = (xDiff * xDiff) + (yDiff * yDiff);

            if (distanceSquared > (pointDistanceSquared * 1.2)) {
                continue;
            }

            context.beginPath();
            context.moveTo(point.x, point.y);
            context.lineTo(neighbour.x, neighbour.y);

            context.lineWidth = (1 - (distanceSquared / (pointDistanceSquared * 1.2))) * 10;
            context.strokeStyle = `rgba(${rgb}, ${1 - (distanceSquared / (pointDistanceSquared * 1.2))})`;
            context.stroke();
        }

        // console.groupEnd();
    }

    // Draw points
    for (let i = 0; i < points.length; i++) {
        context.fillStyle = darkMode ? "#FFF" : "#000";
        context.strokeStyle = darkMode ? "#FFF" : "#000";

        const point = points[i];

        context.moveTo(point.x, point.y);
        context.beginPath();
        context.arc(point.x, point.y, Math.min(10, 1 + (point.neighbourDist * point.neighbourDist) / 2), 0, Math.PI * 2);
        context.closePath();
        context.fill();

        // Debugging
        if (debug && i === 50) {
            context.beginPath();
            context.moveTo(point.x, point.y);
            context.lineTo((point.x + point.xVelocity * 10), (point.y + point.yVelocity * 10));
            context.closePath();

            context.strokeStyle = `red`;
            context.lineWidth = 2;
            context.stroke();

            context.fillStyle = 'red';
            context.textAlign = 'left';
            context.font = "12px monospace";

            printAt(JSON.stringify(point, null, 2), 20, 20 + 20, 12);
        }
    }
}

function generatePoints() {
    const area = canvas.width * canvas.height;
    const pointCount = area * pointCountAreaRatio;

    // const rows = 10;
    // const cols = Math.round(pointCount / rows);

    // const availableWidth = canvas.width + (pointPadding * 2);
    // const availableHeight = canvas.height + (pointPadding * 2);

    points = [];

    for (let i = 0; i < pointCount; i++) {
        // const iteration = i + 1;
        // const column = i % cols;
        // const row = Math.floor(i / rows);

        points.push({
            x: (Math.random() * (canvas.width + pointPadding)) - halfPointPadding,
            y: (Math.random() * (canvas.height + pointPadding)) - halfPointPadding,
            xVelocity: (Math.random() - .5) / 100,
            yVelocity: (Math.random() - .5) / 100,
            neighbourCount: 0,
            neighbourDist: 0,
        })
    }
}

function resize() {
    const { width, height } = canvas.getBoundingClientRect();

    canvas.width = width;
    canvas.height = height;

    generatePoints();
}

function printAt(text, x, y, lineHeight) {
    var lines = text.split('\n');

    for (var i = 0; i < lines.length; i++)
        context.fillText(lines[i], x, y + (i * lineHeight));
}

export default bgCanvas;
