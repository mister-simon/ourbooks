function clamp(min, max, val) {
    return Math.min(Math.max(val, min), max);
}

function mouseListener(e) {
    // Element details
    const { width, height } = this.$el.getBoundingClientRect();
    const t = this.$el.offsetTop;
    const l = this.$el.offsetLeft;

    // Mouse details
    const mt = e.pageY;
    const ml = e.pageX;

    // Diffs
    const lDiff = ml - l;
    const tDiff = mt - t;

    // Normalised
    const normL = ((lDiff / width) - .5) * 2;
    const normT = ((tDiff / height) - .5) * 2;

    this.y = clamp(-45, 45, normL * 10);
    this.x = clamp(-45, 45, normT * -10);
}


document.addEventListener('alpine:init', () => {
    Alpine.data('welcomeBook', () => ({
        open: false,
        x: 5,
        y: 0,
        z: 0,
        timeout: null,
        bindings: {
            ['@mousemove.window']: mouseListener,
            ['@click']() {
                this.open = true;
                clearTimeout(this.timeout);
            },
            'draggable': "false"
        },
        init() {
            this.timeout = setTimeout(() => this.open = true, 2000);
        }
    }));
});
