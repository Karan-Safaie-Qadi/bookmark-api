// ========================
// Configuration
// ========================
const API_BASE = '/api';  // یا در صورت نیاز http://localhost:8000/api

// ========================
// State
// ========================
let currentToken = localStorage.getItem('bookmark_token') || null;
let deleteTargetId = null;

// ========================
// DOM Elements
// ========================
const loginScreen = document.getElementById('loginScreen');
const appScreen = document.getElementById('appScreen');
const loginError = document.getElementById('loginError');
const usernameInp = document.getElementById('username');
const passwordInp = document.getElementById('password');
const loginBtn = document.getElementById('loginBtn');

const themeToggle = document.getElementById('themeToggle');
const logoutBtn = document.getElementById('logoutBtn');
const searchInput = document.getElementById('searchInput');
const bookmarkList = document.getElementById('bookmarkList');
const addBtn = document.getElementById('addBtn');

const bookmarkModal = document.getElementById('bookmarkModal');
const modalTitle = document.getElementById('modalTitle');
const urlInput = document.getElementById('urlInput');
const titleInput = document.getElementById('titleInput');
const editId = document.getElementById('editId');
const saveBtn = document.getElementById('saveBookmarkBtn');
const cancelModalBtn = document.getElementById('cancelModalBtn');
const formError = document.getElementById('formError');

const deleteModal = document.getElementById('deleteModal');
const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

const toastContainer = document.getElementById('toastContainer');

// ========================
// Utility Functions
// ========================
function showToast(message, type = 'success') {
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
  toast.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
  toastContainer.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

function normalizeUrl(raw) {
  let url = raw.trim();
  url = url.replace(/\\/g, '/');
  if (!/^https?:\/\//i.test(url)) url = 'https://' + url;
  return url;
}

function escapeHtml(text) {
  return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ========================
// Theme Toggle
// ========================
function applyTheme(theme) {
  if (theme === 'light') {
    document.body.classList.add('light-mode');
    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
  } else {
    document.body.classList.remove('light-mode');
    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
  }
}
const savedTheme = localStorage.getItem('theme') || 'dark';
applyTheme(savedTheme);

themeToggle.addEventListener('click', () => {
  const newTheme = document.body.classList.contains('light-mode') ? 'dark' : 'light';
  applyTheme(newTheme);
  localStorage.setItem('theme', newTheme);
});

// ========================
// Authentication
// ========================
async function apiCall(url, method = 'GET', body = null) {
  const headers = {
    'Content-Type': 'application/json',
    'Authorization': 'Bearer ' + currentToken
  };
  const options = { method, headers };
  if (body) options.body = JSON.stringify(body);

  const response = await fetch(url, options);
  if (response.status === 401) {
    logout();
    throw new Error('نشست منقضی شد. لطفاً دوباره وارد شوید');
  }
  if (!response.ok) {
    const error = await response.json();
    throw new Error(error.error || 'خطای ناشناخته');
  }
  return response.json();
}

function login() {
  const username = usernameInp.value.trim();
  const password = passwordInp.value.trim();
  loginError.textContent = '';

  fetch(`${API_BASE}/auth`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ username, password })
  })
  .then(res => res.json())
  .then(data => {
    if (data.token) {
      currentToken = data.token;
      localStorage.setItem('bookmark_token', currentToken);
      showApp();
    } else {
      throw new Error(data.error || 'ورود ناموفق');
    }
  })
  .catch(err => {
    loginError.textContent = err.message;
    showToast(err.message, 'error');
  });
}

function logout() {
  currentToken = null;
  localStorage.removeItem('bookmark_token');
  showLogin();
}

function showLogin() {
  loginScreen.classList.add('active');
  appScreen.classList.remove('active');
}

function showApp() {
  loginScreen.classList.remove('active');
  appScreen.classList.add('active');
  loadBookmarks();
}

// ========================
// Bookmarks CRUD
// ========================
async function loadBookmarks() {
  const q = searchInput.value.trim();
  let endpoint = `${API_BASE}/bookmarks`;
  if (q) endpoint += `?q=${encodeURIComponent(q)}`;

  try {
    const data = await apiCall(endpoint);
    renderBookmarks(data);
  } catch (err) {
    showToast(err.message, 'error');
    bookmarkList.innerHTML = '<p class="error-msg">خطا در بارگذاری</p>';
  }
}

function renderBookmarks(bookmarks) {
  if (!bookmarks.length) {
    bookmarkList.innerHTML = '<p style="text-align:center; color:var(--text-secondary);">هیچ بوکمارکی یافت نشد</p>';
    return;
  }

  

  bookmarkList.innerHTML = bookmarks.map(b => `
    <div class="bookmark-card">
      <div>
        <a href="${b.url}" target="_blank" rel="noopener">${escapeHtml(b.title)}</a>
        <small>${new Date(b.created_at).toLocaleString('fa-IR')}</small>
      </div>
      <div class="bookmark-actions">
        <button class="btn-secondary" onclick="openEditModal(${b.id}, '${escapeHtml(b.url)}', '${escapeHtml(b.title)}')"><i class="fas fa-edit"></i></button>
        <button class="btn-danger" onclick="openDeleteModal(${b.id})"><i class="fas fa-trash"></i></button>
      </div>
    </div>
  `).join('');
}

async function saveBookmark() {
  const id = editId.value;
  const rawUrl = urlInput.value.trim();
  const title = titleInput.value.trim();
  formError.textContent = '';

  if (!rawUrl) {
    formError.textContent = 'آدرس الزامی است';
    return;
  }

  const url = normalizeUrl(rawUrl);
  const method = id ? 'PUT' : 'POST';
  let endpoint = `${API_BASE}/bookmarks`;
  if (id) endpoint += `?id=${id}`;

  try {
    await apiCall(endpoint, method, { url, title });
    closeModal(bookmarkModal);
    loadBookmarks();
    showToast(id ? 'بوکمارک ویرایش شد' : 'بوکمارک جدید اضافه شد', 'success');
  } catch (err) {
    formError.textContent = err.message;
    showToast(err.message, 'error');
  }
}

// Delete flow
function openDeleteModal(id) {
  deleteTargetId = id;
  deleteModal.classList.add('active');
}
async function confirmDelete() {
  if (!deleteTargetId) return;
  try {
    await apiCall(`${API_BASE}/bookmarks?id=${deleteTargetId}`, 'DELETE');
    closeModal(deleteModal);
    loadBookmarks();
    showToast('بوکمارک حذف شد', 'success');
  } catch (err) {
    showToast(err.message, 'error');
  }
}

// ========================
// Modal Controls
// ========================
function openModal(modal) {
  modal.classList.add('active');
}
function closeModal(modal) {
  modal.classList.remove('active');
}

function openEditModal(id, url, title) {
  editId.value = id;
  urlInput.value = url;
  titleInput.value = title;
  modalTitle.textContent = 'ویرایش بوکمارک';
  formError.textContent = '';
  openModal(bookmarkModal);
}

function openAddModal() {
  editId.value = '';
  urlInput.value = '';
  titleInput.value = '';
  modalTitle.textContent = 'افزودن بوکمارک جدید';
  formError.textContent = '';
  openModal(bookmarkModal);
}

// ========================
// Event Listeners
// ========================
loginBtn.addEventListener('click', login);
logoutBtn.addEventListener('click', logout);
addBtn.addEventListener('click', openAddModal);
saveBtn.addEventListener('click', saveBookmark);
cancelModalBtn.addEventListener('click', () => closeModal(bookmarkModal));
confirmDeleteBtn.addEventListener('click', confirmDelete);
cancelDeleteBtn.addEventListener('click', () => closeModal(deleteModal));
searchInput.addEventListener('input', loadBookmarks);

// Close modals on overlay click
[bookmarkModal, deleteModal].forEach(modal => {
  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal(modal);
  });
});

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    closeModal(bookmarkModal);
    closeModal(deleteModal);
  }
});

// ========================
// Initialize
// ========================
if (currentToken) {
  showApp();
} else {
  showLogin();
}