<?php
require_once '../includes/db.php';
require_once '../classes/Service.php';

$service = new Service($pdo);
// Search
$search = $_GET['search'] ?? '';
$services = $service->search($search); 
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php'; ?>

<body class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<main class="flex-1 flex items-center justify-center px-4 py-12">
        <section class="max-w-7xl w-full px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100 mb-8">
                Our Photography Services
            </h2>

            <form method="GET" class="mb-8 flex justify-center">
                <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Search for a service…"
                    class="w-full md:w-1/2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 ">
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg ">
                    Search
                </button>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if (count($services) > 0): ?>
                    <?php foreach ($services as $s): ?>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg  p-6 text-center">
                            <img src="<?= htmlspecialchars($s['image'])  ?>"
                                class="w-20 h-20 mb-4 rounded-full bg-gray-100 dark:bg-gray-700 p-2 mx-auto">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                                <?= htmlspecialchars($s['title']) ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                <?= htmlspecialchars($s['description']) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center col-span-3 text-gray-600 dark:text-gray-400">No services found matching your search.</p>
                <?php endif; ?>
            </div>

        </section>
    </main>

    <?php include '../layout/footer.php'; ?>

    <!-- Your existing script.js (renders & filters cards) -->
    <script src="/Practical-Assignment-3/js/script.js"></script>


</body>

</html>