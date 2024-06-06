function nextPage(pageNumber) {
    const currentPage = document.querySelector('.form-page.active');
    const nextPage = document.getElementById('page' + pageNumber);
    if (currentPage) {
        currentPage.classList.remove('active');
    }
    if (nextPage) {
        nextPage.classList.add('active');
    }
}

function previousPage(pageNumber) {
    nextPage(pageNumber);
}

document.getElementById('postal').addEventListener('input', function (e) {
    const input = e.target;
    const errorMessage = document.getElementById('error-message');
    if (input.value.length !== 6) {
        errorMessage.style.display = 'block';
    } else {
        errorMessage.style.display = 'none';
    }
});

window.onload = function() {
    document.getElementById('page1').classList.add('active');
}
