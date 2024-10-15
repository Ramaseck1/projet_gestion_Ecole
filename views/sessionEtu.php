<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar with sessions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Aucune modification nécessaire pour le modal si ce n'est pas utilisé */
    </style>
</head>
<body class="bg-gray-100 h-screen">
    <?php if (!empty($message)): ?>
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-custom-purple">
                <span class="text-blue-500">Ecole</span> <span class="text-custom-orange">221</span>
            </div>
            <nav class="space-x-4 flex">
                <a href="#" class="text-gray-600 hover:text-custom-purple mt-2">Accueil</a>

            <form action="/courEtu" method="POST">
                    <button value="<?php echo htmlspecialchars($_SESSION['user']->getId()); ?>" class="flex items-center p-2 text-gray-700 hover:bg-blue-100 rounded-lg">
                        <span class="material-icons"></span>
                        <span class="ml-2">Mes cours</span>
                    </button>
                </form>                <form action="/calendar" method="POST">
                    <button value="<?php echo htmlspecialchars($_SESSION['user']->getId()); ?>" class="flex items-center p-2 text-gray-700 hover:bg-blue-100 rounded-lg">
                        <span class="material-icons"></span>
                        <span class="ml-2">Calendrier</span>
                    </button>
                </form>
            </nav>
            <div class="relative flex gap-4">
                <div class="bg-gray-200 text-gray-700 py-2 px-4 rounded-full">
                    <span><?php echo htmlspecialchars($_SESSION['user']->getNom().' '.$_SESSION['user']->getPrenom()); ?></span>
                </div>
                <a href="/logout" class="mt-3">Se déconnecter</a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 flex justify-center items-center">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-3xl h-80 mt-10" style="height:80vh">
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
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const monthYearEl = document.getElementById('monthYear');
            const calendarDaysEl = document.getElementById('calendarDays');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');

            let currentDate = new Date();

            const sessionss = <?php echo json_encode($sessionss); ?>;

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
                    const session = sessionss.find(session => new Date(session.date).toDateString() === date.toDateString());

                    let sessionText = '';

                    if (session) {
                        sessionText = `<br><span class="text-sm text-blue-600">${session.cour_nom} - ${session.heureDebut} - ${session.heureFin}</span>`;
                    }

                    calendarDaysEl.innerHTML += `<div class="py-4">${i}${sessionText}</div>`;
                }
            }

            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            renderCalendar();
        });
    </script>
</body>
</html>
