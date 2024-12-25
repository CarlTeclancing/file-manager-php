<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple File Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-4">Simple File Manager</h1>
        
        <!-- Upload Form -->
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="mb-6">
            <input type="file" name="file" class="block mb-2">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Upload</button>
        </form>

        <!-- File List -->
        <h2 class="text-xl font-bold mb-4">Uploaded Files</h2>
        <ul class="bg-white shadow-md rounded-lg p-4">
            <?php
            $files = array_diff(scandir('uploads'), array('.', '..'));
            foreach ($files as $file):
            ?>
                <li class="flex justify-between items-center mb-2 bg-white shadow-md rounded-lg p-4">
                    <span><?php echo $file; ?></span>
                    <div class="">
                        <a href="download.php?file=<?php echo urlencode($file); ?>" class="text-blue-500 mr-2 ">Download</a>
                        <a href="delete.php?file=<?php echo urlencode($file); ?>" class="text-red-500">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
