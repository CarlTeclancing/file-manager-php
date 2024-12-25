
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-4">Project Management</h1>

        <!-- Add Project Form -->
        <form id="projectForm" class="mb-6 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-2">Add/Edit Project</h2>
            <input type="hidden" id="projectId" name="id">
            <input type="text" id="projectName" name="name" placeholder="Project Name" class="block w-full mb-2 p-2 border rounded" required>
            <textarea id="projectDescription" name="description" placeholder="Description" class="block w-full mb-2 p-2 border rounded"></textarea>
            <select id="projectStatus" name="status" class="block w-full mb-2 p-2 border rounded">
                <option value="pending">Pending</option>
                <option value="in progress">In Progress</option>
                <option value="finished">Finished</option>
            </select>
            <input type="number" id="timeAllocation" name="time_allocation" placeholder="Time Allocation (hours)" class="block w-full mb-2 p-2 border rounded" required>
            <input type="text" id="projectType" name="type" placeholder="Project Type" class="block w-full mb-2 p-2 border rounded" required>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save Project</button>
        </form>

        <!-- Project List -->
        <h2 class="text-xl font-bold mb-4">Projects</h2>
        <div id="projectList" class="bg-white p-4 rounded shadow"></div>
    </div>

    <script>
        const apiBase = 'api/';

        // Fetch and render projects
        const fetchProjects = async () => {
            const response = await fetch(apiBase + 'getProjects.php');
            const projects = await response.json();
            renderProjects(projects);
        };

        // Render projects
        const renderProjects = (projects) => {
            const projectList = document.getElementById('projectList');
            projectList.innerHTML = '';
            projects.forEach((project) => {
                const projectCard = document.createElement('div');
                projectCard.className = 'p-4 mb-2 border rounded flex justify-between';
                projectCard.innerHTML = `
                    <div>
                        <h3 class="font-bold">${project.name}</h3>
                        <p>${project.description}</p>
                        <p>Status: ${project.status}</p>
                        <p>Time Allocation: ${project.time_allocation} hours</p>
                        <p>Type: ${project.type}</p>
                    </div>
                    <div>
                        <button class="px-4 py-2 bg-green-500 text-white rounded mr-2" onclick="editProject(${project.id})">Edit</button>
                        <button class="px-4 py-2 bg-red-500 text-white rounded" onclick="deleteProject(${project.id})">Delete</button>
                    </div>
                `;
                projectList.appendChild(projectCard);
            });
        };

        // Save project
        document.getElementById('projectForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const projectId = formData.get('id');
            const apiUrl = projectId ? 'updateProject.php' : 'addProject.php';
            await fetch(apiBase + apiUrl, { method: 'POST', body: formData });
            e.target.reset();
            fetchProjects();
        });

        // Edit project
        const editProject = (id) => {
            fetch(apiBase + 'getProjects.php')
                .then((response) => response.json())
                .then((projects) => {
                    const project = projects.find((p) => p.id === id);
                    if (project) {
                        document.getElementById('projectId').value = project.id;
                        document.getElementById('projectName').value = project.name;
                        document.getElementById('projectDescription').value = project.description;
                        document.getElementById('projectStatus').value = project.status;
                        document.getElementById('timeAllocation').value = project.time_allocation;
                        document.getElementById('projectType').value = project.type;
                    }
                });
        };

        // Initial load
        fetchProjects();
    </script>
</body>
</html>
    