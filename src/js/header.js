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

    let a = document.querySelectorAll('a');
    a.forEach((el) => {

      el.addEventListener('click', (event) => {

        if(event.target.hash && window.location.pathname === "/"){
          event.preventDefault();
          let link = document.querySelector(event.target.hash);
            if(link){
            window.scrollTo({ top: link.offsetTop-59, behavior: 'smooth' });
          }
        }

        if (event.target.closest('.header-nav')) {
            if(mobileWrap.classList.contains('open')){
              this.menuToggle.classList.toggle('open');
              mobileWrap.classList.toggle('open');
            }
        }


      })
    })

    //this.headerNav.querySelector('')

  },


}

export default header;