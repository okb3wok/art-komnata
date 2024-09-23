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



        if(event.target.hash && event.target.baseURI === event.target.origin+"/"){
          event.preventDefault();
          let link = document.querySelector(event.target.hash);
          if(link){
            if(mobileWrap.classList.contains('open')){
              this.menuToggle.classList.toggle('open');
              mobileWrap.classList.toggle('open');
            }
            //window.location = event.target.origin;

            window.scrollTo({ top: link.offsetTop-59, behavior: 'smooth' });
          }

        }


      })
    })

    //this.headerNav.querySelector('')

  },


}

export default header;