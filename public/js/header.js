const profileBtn = document.getElementById('profileBtn');
const profileMenu = document.getElementById('profileMenu');

// Mostrar / Ocultar menú al hacer clic en la foto
profileBtn.addEventListener('click', (e) => {
  e.stopPropagation();
  profileMenu.classList.toggle('hidden');
});

// Cerrar el menú si se hace clic fuera de él
document.addEventListener('click', (e) => {
  if (!profileMenu.contains(e.target) && !profileBtn.contains(e.target)) {
    profileMenu.classList.add('hidden');
  }
});