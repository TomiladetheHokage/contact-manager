<?php
session_start();
$error = $_SESSION['error'] ?? '';
$old = $_SESSION['old'] ?? null;

// Clear error/old after displaying
unset($_SESSION['error']);
unset($_SESSION['old']);

$editId = $old['id'] ?? '';
$editName = $old['name'] ?? '';
$editEmail = $old['email'] ?? '';
$editPhone = $old['phone'] ?? '';

// Assuming $contacts contains the contact data from your database
$contacts = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '+123456789'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '+987654321'],
    // Add more contacts here...
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact List</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen p-8">
  <div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Contact List</h1>
      <a href="/contact-manager2/index.php?action=create" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        + Add Contact
      </a>
    </div>

    <div class="relative mb-6">
      <input
        type="text"
        id="searchInput"
        placeholder="Search contacts..."
        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-indigo-500"
        onkeyup="filterContacts()"
      />
      <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</div>
    </div>

    <!-- Contact Table -->
    <?php if (empty($contacts)): ?>
      <p class="text-gray-500">No contacts found.</p>
    <?php else: ?>
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <table id="contact-table" class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <!-- Loop through contacts -->
            <?php foreach ($contacts as $contact): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($contact['name']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($contact['email']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($contact['phone']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex gap-2">
                    <a href="/contact-manager2/index.php?action=delete&id=<?= $contact['id'] ?>" class="text-blue-600 hover:text-blue-800">Delete</a>
                    <button
                      onclick="openEditModal(<?= $contact['id'] ?>, 
                      '<?= htmlspecialchars($contact['name'], ENT_QUOTES) ?>', 
                      '<?= htmlspecialchars($contact['email'], ENT_QUOTES) ?>', 
                      '<?= htmlspecialchars($contact['phone'], ENT_QUOTES) ?>')"
                      class="text-blue-600 hover:text-blue-800"> Edit
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

  <!-- Edit Modal (You have this already) -->

  <script>
    function filterContacts() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const rows = document.querySelectorAll('#contact-table tbody tr');

      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
      });
    }

    function openEditModal(id, name, email, phone) {
      document.getElementById('editId').value = id;
      document.getElementById('editName').value = name;
      document.getElementById('editEmail').value = email;
      document.getElementById('editPhone').value = phone;

      const modal = document.getElementById('editModal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }

    function closeModal() {
      document.getElementById('editModal').classList.remove('flex');
      document.getElementById('editModal').classList.add('hidden');
    }
  </script>
</body>
</html>
