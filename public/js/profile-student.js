function getInitials(name) {
    return name
        .trim()
        .split(/\s+/)
        .slice(0, 2)
        .map(word => word[0])
        .join('')
        .toUpperCase();
}

function stringToColor(str, s = 65, l = 55) {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    const h = Math.abs(hash) % 360;
    return `hsl(${h}, ${s}%, ${l}%)`;
}

const el = document.getElementById('initial');
const profile = document.getElementById('profile');

if (el) {
    const name = el.dataset.name;
    el.textContent = getInitials(name);
    profile.style.backgroundColor = stringToColor(name);
}
