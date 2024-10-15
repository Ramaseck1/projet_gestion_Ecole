<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar with sessions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-100 h-screen flex gap-20">
    <div class="w-1/4 bg-white shadow-md">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-8">Logo</h1>
            <nav>
                <ul>
                    <li class="mb-4">
                        <button class="flex items-center p-2 text-blue-500 bg-blue-100 rounded-lg">
                            <span class="material-icons">dashboard</span>
                        </button>
                    </li>
                    <li class="mb-4">
                        <form action="/profs" method="POST">
                            <button value="<?php echo htmlspecialchars($_SESSION['user']->getId()); ?>" class="flex items-center p-2 text-gray-700 hover:bg-blue-100 rounded-lg">
                                <span class="material-icons"></span>
                                <span class="ml-2">Cours</span>
                            </button>
                        </form>
                    </li>
                    <li class="mb-4">
                        <form action="/session" method="POST">
                            <button value="<?php echo htmlspecialchars($_SESSION['user']->getId()); ?>" class="flex items-center p-2 text-gray-700 hover:bg-blue-100 rounded-lg">
                                <span class="material-icons"></span>
                                <span class="ml-2">sessions</span>
                            </button>
                        </form>
                    </li>
                    <li class="mb-4">
                        <button class="flex items-center p-2 text-gray-700 hover:bg-blue-100 rounded-lg">
                            <span class="material-icons"></span>
                            <span class="ml-2">Demande d'annulations</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="bg-gray-100 h-screen flex flex-col items-center">
    <?php if (!empty($message)): ?>
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <?php echo $message  ; ?>
            </div>
        <?php endif; ?>
        <div class="flex justify-end items-center mb-8 bg-gray-200 p-5 border rounded-20" style="margin-left:900px">
            <div class="flex items-center space-x-4">
                <span><?php echo htmlspecialchars($_SESSION['user']->getNom().' '.$_SESSION['user']->getPrenom()); ?> <a href="/logout">Se déconnecter</a></span>
            </div>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-3xl h-80 mt-10" style="height:80vh;margin-left:-200px;">
             <form method="GET" action="/session">
                <label for="status">Filtrer par statut :</label>
                <select name="status" id="status" onchange="this.form.submit()">
                    <option value="">Tous</option>
                    <option value="non effectue" <?php echo (isset($_GET['status']) && $_GET['status'] === 'non effectue') ? 'selected' : ''; ?>>Non effectué</option>
                    <option value="terminer" <?php echo (isset($_GET['status']) && $_GET['status'] === 'terminer') ? 'selected' : ''; ?>>Terminé</option>
                    <option value="annulé" <?php echo (isset($_GET['status']) && $_GET['status'] === 'annulé') ? 'selected' : ''; ?>>Annulé</option>
                </select>
            </form>
            <div class="flex justify-between items-center mb-6">
                <button id="prevMonth" class="text-gray-700 hover:text-gray-900">&lt;</button>
                <h2 id="monthYear" class="text-2xl font-bold"></h2>
                <button id="nextMonth" class="text-gray-700 hover:text-gray-900">&gt;</button>
            </div>
            <div class="grid grid-cols-7 gap-4 text-center">
                <div class="font-bold text-lg">Sun</div>
                <div class="font-bold text-lg">Mon</div>
                <div class="font-bold text-lg">Tue</div>
                <div class="font-bold text-lg">Wed</div>
                <div class="font-bold text-lg">Thu</div>
                <div class="font-bold text-lg">Fri</div>
                <div class="font-bold text-lg">Sat</div>
                <div id="calendarDays" class="col-span-7 grid grid-cols-7 gap-4"></div>
            </div>
        </div>
      
    </div>

    <!-- Modal -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <h3 class="text-lg font-bold mb-4">Demande d'annulation</h3>
            <form id="cancelForm" action="/session" method="POST">
                <input type="hidden" name="session_id" id="sessionId">
                <div class="mb-4">
                    <label for="reason" class="block text-gray-700">Raison de l'annulation :</label>
                    <textarea id="reason" name="reason" rows="4" class="w-full p-2 border rounded"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Envoyer</button>
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded ml-2 hover:bg-gray-400">Fermer</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const monthYearEl = document.getElementById('monthYear');
            const calendarDaysEl = document.getElementById('calendarDays');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');
            const cancelModal = document.getElementById('cancelModal');
            const closeModalBtn = document.getElementById('closeModal');

            let currentDate = new Date();

            const sessions = <?php echo json_encode($sessions); ?>;

            function renderCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                monthYearEl.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;

                const firstDayOfMonth = new Date(year, month, 1).getDay();
                const lastDateOfMonth = new Date(year, month + 1, 0).getDate();

                calendarDaysEl.innerHTML = '';

                for (let i = 0; i < firstDayOfMonth; i++) {
                    calendarDaysEl.innerHTML += '<div></div>';
                }
                    
                for (let i = 1; i <= lastDateOfMonth; i++) {
                    const date = new Date(year, month, i);
                    const session = sessions.find(session => new Date(session.date).getTime() === date.getTime());

                    let sessionText = '';
                    let bgColor = '';
                    let buttonHtml = '';

                    if (session) {
                        sessionText = `<br><span class="text-sm text-blue-600">${session.cour_nom} - ${session.heureDebut} - ${session.heureFin} - ${session.status}</span>`;
                        if (session.status === 'Terminé') {
                            bgColor = 'bg-green-300';
                        } else if (session.status === 'Annulé') {
                            bgColor = 'bg-red-300';
                        } else if (session.status === 'Non effectué') {
                            bgColor = 'bg-yellow-300';
                            buttonHtml = `<button class="text-sm text-blue-600  bg-gray-200" data-session-id="${session.id}">Demande annulation</button>`;
                        }
                    }

                    calendarDaysEl.innerHTML += `<div class="py-4 ${bgColor}">${i}${sessionText}${buttonHtml}</div>`;
                }

                // Gestion du clic sur le bouton de demande d'annulation
                document.querySelectorAll('button[data-session-id]').forEach(button => {
                    button.addEventListener('click', (event) => {
                        const sessionId = event.target.getAttribute('data-session-id');
                        document.getElementById('sessionId').value = sessionId;
                        cancelModal.style.display = 'flex';
                    });
                });
            }

            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            closeModalBtn.addEventListener('click', () => {
                cancelModal.style.display = 'none';
            });

            renderCalendar();
        });
    </script>
  
  
</body>
</html>
