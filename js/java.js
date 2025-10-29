    const btnMenu = document.getElementById('btnMenu');
const sidebar = document.getElementById('sidebar');
const conteudo = document.getElementById('conteudo');
const btnTema = document.getElementById('btnTema');
const formCategoria = document.getElementById('formCategoria');

// Carregar tema salvo
const temaAtual = localStorage.getItem('tema') || 'dark';
if (temaAtual === 'light') {
    document.body.classList.add('light-mode');
    btnTema.innerHTML = '<i class="bi bi-sun-fill"></i>';
}

btnMenu.onclick = () => {
    sidebar.classList.toggle('ativo');
    conteudo.classList.toggle('shift');
    // btnMenu.classList.toggle('clicado');
};

btnCategoria.onclick = () => {
    formCategoria.classList.toggle('ativo');
};

btnTema.onclick = () => {
    document.body.classList.toggle('light-mode');
    const isLightMode = document.body.classList.contains('light-mode');
    
    // Mudar ícone
    btnTema.innerHTML = isLightMode ? 
        '<i class="bi bi-sun-fill"></i>' : 
        '<i class="bi bi-moon-fill"></i>';
    
    // Salvar preferência
    localStorage.setItem('tema', isLightMode ? 'light' : 'dark');
};