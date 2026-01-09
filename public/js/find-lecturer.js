document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const container = document.getElementById('lecturerContainer');

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
                        container.innerHTML = '<p>No lecturers found.<p>';
                        return;
                    }

                    data.forEach(lecturer => {
                        console.log(lecturer.image_path)
                        container.innerHTML += `
                            <div class="profile glass">
                                <div class="left">
                                    <img src="/storage/${lecturer.image_path}" alt="profile image">
                                </div>
                                <div class="right">
                                    <div class="upper">
                                        <h1>${lecturer.name}</h1>
                                        <p>${lecturer.profile}</p>
                                        <div class="in-rows">
                                            <div class="item">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                                                <div class="item-info">
                                                    <h3>${window.LANG['email']}</h3>
                                                    <p>${lecturer.email}</p>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg>
                                                <div class="item-info">
                                                    <h3>${window.LANG['phone number']}</h3>
                                                    <p>${lecturer.phone}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reverse">
                                        ${lecturer.is_assigned ? `
                                            <a href="${consultCreateUrl}" class="button blue">
                                                Reserve Appointment
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                            </a>
                                        ` : ''}
                                        <a href="${seeScheduleUrl}" class="button white">
                                            See Schedule
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                });
        }, 300); // debounce
    });
});