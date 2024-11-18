function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('main-content');
    sidebar.classList.toggle('collapsed');
    content.classList.toggle('collapsed');
}

function toggleCard(card) {
    card.classList.toggle('expanded');
}

function showModal() {
    document.getElementById('modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}
