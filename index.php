<?php
require("headers.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
</head>
<body>
    <h2>Lista de Tareas</h2>

    <div id="task-list">
    </div>

    <button id="add-task-button">Agregar Tarea</button>
    <button id="logout-button">Cerrar Sesión</button>

    <script>

        fetch("ajax.tareas.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const taskList = document.getElementById("task-list");
                    taskList.innerHTML = ""; 
                    data.tasks.forEach(task => {
                        const taskItem = document.createElement("div");
                        taskItem.textContent = task.tarea;
                        taskList.appendChild(taskItem);
                    });
                } else {
                    console.error("Error al obtener las tareas:", data.message);
                }
            })
            .catch(error => {
                console.error("Error al enviar la solicitud:", error);
            });

        document.getElementById("add-task-button").addEventListener("click", function() {
            const newTaskForm = document.createElement("form");
            newTaskForm.innerHTML = `
                <label for="new-task">Nueva Tarea:</label><br>
                <input type="text" id="new-task" name="new-task" required><br><br>
                <button type="submit">Agregar</button>
                <button type="button" onclick="cancelAddTask()">Cancelar</button>
            `;
            newTaskForm.addEventListener("submit", function(event) {
                event.preventDefault();
                const newTask = document.getElementById("new-task").value;
                addTask(newTask);
                newTaskForm.remove();
            });
            document.body.appendChild(newTaskForm);
        });

        document.getElementById("logout-button").addEventListener("click", function() {
            logout();
        });

        function addTask(task) {
            const formData = new FormData();
            formData.append('task', task);

            fetch("ajax.tareas.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Nueva tarea agregada:", task);
                    window.location.reload();
                } else {
                    const errorMessage = document.createElement("div");
                    errorMessage.style.color = "red";
                    errorMessage.textContent = "Error al agregar nueva tarea: " + data.message;
                    document.body.appendChild(errorMessage);
                }
            })
            .catch(error => {
                console.error("Error al enviar la solicitud:", error);
            });
        }

        function cancelAddTask() {
            document.querySelector("form").remove();
        }

        function logout() {
            fetch("ajax.logout.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "login.php";
                } else {
                    console.error("Error al cerrar sesión:", data.message);
                }
            })
            .catch(error => {
                console.error("Error al enviar la solicitud:", error);
            });
        }

    </script>
</body>
</html>
