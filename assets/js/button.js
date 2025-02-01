const button = document.getElementById('button');

button.addEventListener('mouseover', () => {
    button.classList.add('scale');
});

button.addEventListener('mouseout', () => {
    button.classList.remove('scale');
}); 