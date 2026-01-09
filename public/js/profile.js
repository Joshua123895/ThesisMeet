document.getElementById('photoInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const preview = document.getElementById('photoPreview');
    const initial = document.getElementById('initial');
    const profile = document.getElementById('profile');

    const imageUrl = URL.createObjectURL(file);

    console.log(preview);

    if (preview) {
        preview.src = imageUrl;
    } else {
        profile.style.backgroundImage = `url(${imageUrl})`;
        profile.style.backgroundSize = 'cover';
        profile.style.backgroundPosition = 'center';
        profile.style.backgroundRepeat = 'no-repeat';
    }

    if (initial) {
        initial.style.display = 'none';
    }
});