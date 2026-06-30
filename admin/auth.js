const Auth = (() => {

  const ADMIN_USERS = [
    { username: 'admin@korawigire.rw',   password: 'Korawigire@2026', name: 'Administrator',   role: 'Super Admin' },
    { username: 'manager@korawigire.rw', password: 'Manager@2026',    name: 'Content Manager', role: 'Ad Manager'  },
    { username: 'staff@korawigire.rw',   password: 'Staff@2026',      name: 'Staff Member',    role: 'Viewer'      },
  ];

  const SESSION_KEY = 'kw_admin_session';
  const LOGIN_PAGE  = '../staff-login.html';
  const DASHBOARD   = 'dashboard.html';

  function login(username, password) {
    const user = ADMIN_USERS.find(
      u => u.username === username && u.password === password
    );
    if (!user) return { success: false, message: 'Incorrect email or password.' };

    const session = {
      username:  user.username,
      name:      user.name,
      role:      user.role,
      token:     Math.random().toString(36).substring(2) + Date.now().toString(36),
      expiresAt: Date.now() + (8 * 60 * 60 * 1000),
    };
    localStorage.setItem(SESSION_KEY, JSON.stringify(session));
    return { success: true, session };
  }

  function logout() {
    localStorage.removeItem(SESSION_KEY);
    window.location.href = LOGIN_PAGE;
  }

  function getSession() {
    try {
      const raw = localStorage.getItem(SESSION_KEY);
      if (!raw) return null;
      const session = JSON.parse(raw);
      if (Date.now() > session.expiresAt) {
        localStorage.removeItem(SESSION_KEY);
        return null;
      }
      return session;
    } catch { return null; }
  }

  function requireLogin() {
    const session = getSession();
    if (!session) {
      window.location.href = LOGIN_PAGE;
      return null;
    }

    function attachLogout() {
      const nameEl   = document.querySelector('.sidebar-user-name');
      const roleEl   = document.querySelector('.sidebar-user-role');
      const avatarEl = document.querySelector('.sidebar-user-avatar');
      if (nameEl)   nameEl.textContent   = session.name;
      if (roleEl)   roleEl.textContent   = session.role;
      if (avatarEl) avatarEl.textContent = session.name.charAt(0).toUpperCase();

      document.querySelectorAll('[data-action="logout"]').forEach(el => {
        el.addEventListener('click', e => { e.preventDefault(); logout(); });
      });
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', attachLogout);
    } else {
      attachLogout();
    }

    return session;
  }

  function redirectIfLoggedIn() {
    if (getSession()) window.location.href = DASHBOARD;
  }

  return { login, logout, getSession, requireLogin, redirectIfLoggedIn };

})();