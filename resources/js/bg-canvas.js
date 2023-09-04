const debug = false;

/** @type {HTMLCanvasElement} */
let canvas;

/** @type {CanvasRenderingContext2D} */
let context;

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
    requestAnimationFrame(step);

    let delta = frame - prevFrame;
    prevFrame = frame;

    if (delta > 1000) {
        return;
    }

    // Update point positions
    for (let i = 0; i < points.length; i++) {
        // console.groupCollapsed('step ' + i);
        const point = points[i];

        point.neighbourCount = 0;
    }

    for (let i = 0; i < points.length; i++) {
        // console.groupCollapsed('step ' + i);
        const point = points[i];

        point.neighbourCount = 0;

        for (let j = 0; j < points.length; j++) {
            const neighbour = points[j];

            // c2 = x2 + y2
            const xDiff = Math.abs(point.x - neighbour.x);
            const yDiff = Math.abs(point.y - neighbour.y);
            const distanceSquared = (xDiff * xDiff) + (yDiff * yDiff);

            if (distanceSquared > pointDistanceSquared) {
                continue;
            }

            point.neighbourCount += 1 - (distanceSquared / pointDistanceSquared);
            neighbour.neighbourCount += 1 - (distanceSquared / pointDistanceSquared);
        }

        // Update position
        point.x += point.xVelocity * frameTime;
        point.y += point.yVelocity * frameTime;

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
    context.lineWidth = 10;

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

            if (distanceSquared > pointDistanceSquared) {
                continue;
            }

            context.beginPath();
            context.moveTo(point.x, point.y);
            context.lineTo(neighbour.x, neighbour.y);
            context.closePath();

            context.strokeStyle = `rgba(${darkMode ? 255 : 0}, ${darkMode ? 255 : 0}, ${darkMode ? 255 : 0}, ${1 - (distanceSquared / pointDistanceSquared)})`;
            // context.fillText(1 - (distanceSquared / pointDistanceSquared), point.x, point.y);
            context.stroke();
        }

        // console.groupEnd();
    }

    // Draw points
    for (let i = 0; i < points.length; i++) {
        const point = points[i];

        context.moveTo(point.x, point.y);
        context.beginPath();
        context.arc(point.x, point.y, Math.min(10, 1 + (point.neighbourCount * point.neighbourCount) / 2), 0, Math.PI * 2);
        context.closePath();
        context.fill();

        // Debugging
        if (debug) {
            context.beginPath();
            context.moveTo(point.x, point.y);
            context.lineTo((point.x + point.xVelocity * 10000), (point.y + point.yVelocity * 10000));
            context.closePath();

            context.strokeStyle = `red`;
            context.lineWidth = 2;
            context.stroke();
        }
    }
}

function generatePoints() {
    const area = canvas.width * canvas.height;

    const pointCountAreaRatio = 150 / 1086720;
    const pointCount = area * pointCountAreaRatio;

    points = [];

    for (let i = 0; i < pointCount; i++) {
        points.push({
            x: (Math.random() * (canvas.width + pointPadding)) - halfPointPadding,
            y: (Math.random() * (canvas.height + pointPadding)) - halfPointPadding,
            xVelocity: (Math.random() - .5) / 100,
            yVelocity: (Math.random() - .5) / 100,
            neighbourCount: 0
        })
    }
}

function resize() {
    const { width, height } = canvas.getBoundingClientRect();

    canvas.width = width;
    canvas.height = height;

    generatePoints();
}

export default bgCanvas;
