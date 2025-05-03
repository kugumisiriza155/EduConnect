javascript

document.querySelector('.mobile-menu').addEventListener('click', () => {
    const navLinks = document.querySelector('.nav-links');
    navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
});


const courses = [
    { title: "Web Development", desc: "Master HTML/CSS/JS..." },
    { title: "Data Science", desc: "Learn Python & ML..." }
];

const courseGrid = document.querySelector('.course-grid');
courses.forEach(course => {
    const card = document.createElement('div');
    card.className = 'course-card';
    card.innerHTML = `
        <h3>${course.title}</h3>
        <p>${course.desc}</p>
        <button class="enroll-btn">Enroll Now</button>
    `;
    courseGrid.appendChild(card);
});


document.querySelector('#register-form').addEventListener('submit', (e) => {
    const password = document.querySelector('#password').value;
    if (password.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters!');
    }
});
