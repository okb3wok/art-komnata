const toTop = {

  toTop: null,
  init(){
    this.toTop = document.getElementById('toTop');
    if(!this.toTop){
      console.log('[:-(] Can`t find element toTop');
      return;
    }

    window.addEventListener('scroll', () => {
      if (window.scrollY > 220) {
        this.toTop.classList.replace('hide', 'show');
      }
      else {
        this.toTop.classList.replace('show', 'hide');
      }
    })

    this.toTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    })

  }
}

export default toTop
