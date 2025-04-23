<?php
  $error     = $_GET['error'] ?? '';
  $editId    = $_GET['id'] ?? '';
  $editName  = $_GET['name'] ?? '';
  $editEmail = $_GET['email'] ?? '';
  $editPhone = $_GET['phone'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact List</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen p-4 sm:p-8">
  <div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Contact List</h1>
      <a href="/contact-manager2/index.php?action=create" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        + Add Contact
      </a>
    </div>

    <!-- Search -->
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

    <!-- Error Popup -->
    <div id="error-popup" class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 <?= $error ? '' : 'hidden' ?>">
      <div class="flex justify-between items-center">
        <p id="error-message" class="text-sm text-red-700"><?= htmlspecialchars($error) ?></p>
        <button onclick="closeErrorPopup()" class="text-red-500 hover:text-red-700 font-bold text-xl">×</button>
      </div>
    </div>

    <!-- Contacts: Desktop Table -->
    <div class="hidden sm:block">
      <?php if (empty($contacts)): ?>
        <p class="text-gray-500">No contacts found.</p>
      <?php else: ?>
        <div class="bg-white rounded-lg shadow overflow-x-auto">
          <table id="contact-table" class="min-w-full table-fixed divide-y divide-gray-200 text-xl">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider break-words w-1/4">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider break-words w-1/3">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider break-words w-1/4">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php foreach ($contacts as $contact): ?>
                <tr>
                  <td class="px-6 py-4 break-words"><?= htmlspecialchars($contact['name']) ?></td>
                  <td class="px-6 py-4 break-words"><?= htmlspecialchars($contact['email']) ?></td>
                  <td class="px-6 py-4 break-words"><?= htmlspecialchars($contact['phone']) ?></td>
                  <td class="px-6 py-4">
                    <div class="flex gap-2">
                      <button onclick="openEditModal(<?= $contact['id'] ?>, '<?= htmlspecialchars($contact['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($contact['email'], ENT_QUOTES) ?>', '<?= htmlspecialchars($contact['phone'], ENT_QUOTES) ?>')" class="text-blue-600 hover:text-blue-800">Edit</button>
                      <a href="/contact-manager2/index.php?action=delete&id=<?= $contact['id'] ?>" class="text-red-600 hover:text-red-800">Delete</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <p class="px-6 py-4 font-semibold text-gray-700">
             Total contacts: <?php echo isset($contactCount) ? $contactCount : 'Not Available'; ?>
          </p>

          </div>
      <?php endif; ?>
    </div>

    <!-- Contacts: Mobile Cards -->
    <div class="sm:hidden space-y-4" id="mobile-contact-list">
      <?php if (!empty($contacts)): ?>
        <?php foreach ($contacts as $contact): ?>
          <div class="bg-white p-4 rounded-lg shadow">
            <p><strong>Name:</strong> <?= htmlspecialchars($contact['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($contact['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($contact['phone']) ?></p>
            <div class="flex justify-end gap-4 mt-2">
              <button onclick="openEditModal(<?= $contact['id'] ?>, '<?= htmlspecialchars($contact['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($contact['email'], ENT_QUOTES) ?>', '<?= htmlspecialchars($contact['phone'], ENT_QUOTES) ?>')" class="text-blue-600 hover:text-blue-800">Edit</button>
              <a href="/contact-manager2/index.php?action=delete&id=<?= $contact['id'] ?>" class="text-red-600 hover:text-red-800">Delete</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-gray-500">No contacts found.</p>
      <?php endif; ?>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Edit Contact</h2>
        <form method="POST" action="/contact-manager2/index.php?action=update">
          <input type="hidden" name="id" id="editId" value="<?= htmlspecialchars($editId) ?>">
          <div class="mb-4">
            <label class="block text-gray-700">Name</label>
            <input type="text" name="name" id="editName" class="w-full border px-3 py-2 rounded" value="<?= htmlspecialchars($editName) ?>" required>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" id="editEmail" class="w-full border px-3 py-2 rounded" value="<?= htmlspecialchars($editEmail) ?>" required>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700">Phone</label>
            <input type="text" name="phone" id="editPhone" class="w-full border px-3 py-2 rounded" value="<?= htmlspecialchars($editPhone) ?>" required>
          </div>
          <div class="flex justify-end gap-2">
            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function filterContacts() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const rows = document.querySelectorAll('#contact-table tbody tr');
      const cards = document.querySelectorAll('#mobile-contact-list > div');

      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
      });

      cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(input) ? '' : 'none';
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
      const modal = document.getElementById('editModal');
      modal.classList.remove('flex');
      modal.classList.add('hidden');
    }

    function closeErrorPopup() {
      document.getElementById('error-popup').classList.add('hidden');
    }

    window.onload = function () {
      const params = new URLSearchParams(window.location.search);
      const error = params.get('error');
      const showModal = params.get('modal') !== 'false';

      if (error) {
        document.getElementById('error-popup').classList.remove('hidden');
        document.getElementById('error-message').textContent = error;

        if (showModal) {
          const id = params.get('id');
          const name = params.get('name');
          const email = params.get('email');
          const phone = params.get('phone');
          openEditModal(id, name, email, phone);
        }
      }
    };
  </script>
</body>
</html>
