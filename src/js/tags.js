const tags = {

  tags: null,
  currentTag:null,

  init (){
    this.tags = document.querySelector('.gallery__tags');
    if(!this.tags){
      return;
    }

    this.tags.querySelectorAll('a').forEach((el) => {

      el.addEventListener('click', (event) => {
        event.preventDefault();

        const tag = event.target.hash.replace("#", "")

        if(this.currentTag !== tag){
          this.currentTag = tag;

          if(tag ==='all'){

            document.querySelectorAll('.gallery__item').forEach( (el) => {
              el.classList.remove('hidden');
              setTimeout(() => {el.classList.remove('fade');}, 400)
            })

          }else{

            document.querySelectorAll('.gallery__item').forEach( (el) => {

              el.classList.add('fade');
              setTimeout(() => {
                el.classList.add('hidden');

                if(el.classList.contains(tag)){
                  el.classList.remove('hidden');
                  el.classList.remove('fade');
                }

              },400)
            })

          }

        }

      })
    })

  },
}

export default tags;