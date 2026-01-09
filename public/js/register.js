function toggle() {
    document.querySelector('.container')
            .classList.toggle('active');
}

const input = document.getElementById("photo");
const preview = document.getElementById("preview");
const container = document.querySelector(".image-preview");
const placeholder = document.querySelector(".file-placeholder");

input.addEventListener("change", () => {
    const file = input.files[0];
    if (!file) return;

    preview.src = URL.createObjectURL(file);
    container.style.display = "block";
    placeholder.textContent = file.name;
});

