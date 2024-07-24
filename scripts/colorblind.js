const filters = ['protanopia', 'deuteranopia', 'tritanopia', 'achromatopsia', ''];
const filterOverlay = document.getElementById('filter-overlay');

document.addEventListener('DOMContentLoaded', () => {
    let currentFilterIndex = 0;

    function applyFilter() {
        if (filters[currentFilterIndex] === '') {
            filterOverlay.style.display = 'none';
        } else {
            filterOverlay.style.display = 'block';
            filterOverlay.className = filters[currentFilterIndex];
        }
        localStorage.setItem('colorBlindnessFilter', currentFilterIndex);
    }

    function toggleFilter() {
        currentFilterIndex = (currentFilterIndex + 1) % filters.length;
        applyFilter();
    }

    function loadFilter() {
        const savedFilterIndex = localStorage.getItem('colorBlindnessFilter');
        if (savedFilterIndex !== null) {
            currentFilterIndex = parseInt(savedFilterIndex, 10);
            applyFilter();
        }
    }

    function resetFilter() {
        currentFilterIndex = filters.length - 1; // Set to the index of the empty string
        applyFilter();
    }

    loadFilter();

    // Export functions to be used in HTML
    window.toggleFilter = toggleFilter;
    window.resetFilter = resetFilter;
});
