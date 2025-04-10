<button class="btn btn-outline-secondary ms-3" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const contentArea = document.getElementById('contentArea');

        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('full');
        contentArea.style.width = sidebar.classList.contains('closed') ? '100%' : 'calc(100vw - 250px)';
    });

    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickInsideToggle = sidebarToggle.contains(event.target);

        if (!isClickInsideSidebar && !isClickInsideToggle) {
            sidebar.classList.add('closed');
            document.getElementById('mainContent').classList.add('full');
            document.getElementById('contentArea').style.width = '100%';
        }
    });
</script>
