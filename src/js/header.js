const header = {

  header: null,
  headerNav: null,
  menuToggle:null,
  init(){
    this.header = document.querySelector('.header');
    this.headerNav = document.querySelector('.header-nav');
    this.menuToggle = document.querySelector('#menu-toggle');
    if(!this.header || !this.headerNav || !this.menuToggle){
      console.log('[:-(] Can`t find element .header or .header-nav or .menu-toggle');
      return;
    }

    let mobileWrap = document.querySelector('.mobile-wrap');

    this.menuToggle.addEventListener('click', () => {
      this.menuToggle.classList.toggle('open');
      mobileWrap.classList.toggle('open');
    })

    //this.headerNav.querySelector('')

  },


}

export default header;