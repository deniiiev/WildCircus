// Smooth anchor scrolling

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Image on change

const customFileInput = document.querySelector('.custom-file-input');

if (customFileInput) {
    document.querySelector('.custom-file-input').onchange = (event) => {
        const reader = new FileReader();
        reader.onload = () => {
            const output = document.getElementById('outputimage');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
}
