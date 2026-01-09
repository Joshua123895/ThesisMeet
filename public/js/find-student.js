function capitalize(name) {
    const words = name.split(' ');
    const capitalizedWords = words.map(word => {
        if (word.length > 0) {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }
        return word;
    });
    return capitalizedWords.join(' ');
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const container = document.getElementById('studentContainer');

    let debounceTimer;

    searchInput.addEventListener('input', function () {
        console.log('typing detected')
        clearTimeout(debounceTimer);

        const query = this.value.trim();

        debounceTimer = setTimeout(() => {
            fetch(`${window.SEARCH_URL}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                // .then(res => res.text())
                // .then(text => {
                //     console.log(text);
                // });
                .then(data => {
                    container.innerHTML = '';

                    if (data.length === 0) {
                        container.innerHTML = '<p>No students found.<p>';
                        return;
                    }
                    let index = -1;
                    data.forEach(student => {
                        console.log(student.image_path);
                        index += 1;
                        container.innerHTML += `
                        <div class="profile glass" style="animation-delay: ${index * 0.12}s">
                            ${
                                student.image_path ? 
                                `<img src="/storage/${student.image_path}" alt="profile">` 
                                : 
                                `<div class="student-profile">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                                `
                            }
                            <div class="profile-info">
                                <h1>${student.name}</h1>
                                <h2>${student.NIM}</h2>
                                
                            </div>
                            <h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                                ${capitalize(student.major)}
                            </h3>
                            <h3 class="reverse">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                                ${student.email}
                            </h3>
                        </div>
                        `;
                    });
                });
        }, 300); // debounce
    });
});