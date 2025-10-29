    const btnMenu = document.getElementById('btnMenu');
    const sidebar = document.getElementById('sidebar');
    const conteudo = document.getElementById('conteudo');

    btnMenu.onclick = () => {
      sidebar.classList.toggle('ativo');
      conteudo.classList.toggle('shift');
      btnMenu.classList.toggle('clicado');
    };

  const btnCategoria = document.getElementById('btnCategoria');

  btnCategoria.onclick = () => {
    formCategoria.classList.toggle('ativo');
  }