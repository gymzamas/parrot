document.querySelectorAll('input[type="range"]').forEach(slider => {
    slider.addEventListener('input', function() {
        this.form.submit();
    });
});
