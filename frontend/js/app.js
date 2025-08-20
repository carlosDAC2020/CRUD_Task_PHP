
$(document).ready(function() {

    const apiUrl = 'backend/api/';

    // Función para cargar las tareas
    function loadTasks(filter = 'all') {
        let url = `${apiUrl}read.php`;
        if (filter !== 'all') {
            url += `?status=${filter}`;
        }

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#task-list').empty();
                data.forEach(function(task) {
                    $('#task-list').append(`
                        <li data-id="${task.id}" class="${task.status}">
                            <div class="task-info">
                                <strong>${task.title}</strong> - <span>${task.due_date || ''}</span>
                                <p>${task.description || ''}</p>
                            </div>
                            <div class="task-actions">
                                <button class="toggle-status">${task.status === 'pendiente' ? 'Completar' : 'Pendiente'}</button>
                                <button class="delete-task">Eliminar</button>
                            </div>
                        </li>
                    `);
                });
            },
             error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error al cargar tareas:", textStatus, errorThrown);
                $('#task-list').empty().append('<li>Error al cargar las tareas. Revisa la consola.</li>');
            }
        });
    }
    
    // Cargar tareas al iniciar
    loadTasks();

    // Crear una nueva tarea
    $('#task-form').on('submit', function(e) {
        e.preventDefault();
        const task = {
            title: $('#title').val(),
            description: $('#description').val(),
            due_date: $('#due_date').val()
        };

        $.ajax({
            url: `${apiUrl}create.php`,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(task),
            success: function() {
                loadTasks();
                $('#task-form')[0].reset();
            }
        });
    });

    // Marcar como completada/pendiente (toggle)
    $('#task-list').on('click', '.toggle-status', function() {
        const li = $(this).closest('li');
        const id = li.data('id');
        const currentStatus = li.hasClass('pendiente') ? 'pendiente' : 'completada';
        const newStatus = currentStatus === 'pendiente' ? 'completada' : 'pendiente';

        $.ajax({
            url: `${apiUrl}update.php`,
            method: 'POST', // Usamos POST para enviar datos
            contentType: 'application/json',
            data: JSON.stringify({ id: id, status: newStatus }),
            success: function() {
                loadTasks($('.filter-btn.active').data('filter'));
            }
        });
    });

    // Eliminar una tarea
    $('#task-list').on('click', '.delete-task', function() {
        if (confirm('¿Estás seguro de que quieres eliminar esta tarea?')) {
            const id = $(this).closest('li').data('id');
            $.ajax({
                url: `${apiUrl}delete.php`,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ id: id }),
                success: function() {
                    loadTasks($('.filter-btn.active').data('filter'));
                }
            });
        }
    });

    // Filtrar tareas
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        const filter = $(this).data('filter');
        loadTasks(filter);
    });
});