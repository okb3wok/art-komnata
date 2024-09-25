document.addEventListener('DOMContentLoaded', ()=>{


  async function requestAPI(url, method='POST', payload) {
    let response = await fetch(url,{
      method: method,
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify(payload)
    });

    if (response.ok) {
      return await response.json();
    }
    else {
      console.log("Ошибка HTTP: " + response.status);
    }

  }


  function getRandomColor() {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);
    return `rgb(${r}, ${g}, ${b})`;
  }



  const galleryName = document.getElementById('gallery_name');
  if(galleryName){

    const galleryTitle = document.getElementById('gallery_title');
    const galleryDescription = document.getElementById('gallery_desc');
    const galleryThumb= document.getElementById('gallery_thumb');
    const galleryUpdate = document.getElementById('gallery_update');
    const tagsForm = document.getElementById('tagsForm');


    if(tagsForm){

      const addTags = document.getElementById('addTags');
      addTags.addEventListener('click', (event)=>{
        event.preventDefault();


        const randomColor = getRandomColor();


        tagsForm.insertAdjacentHTML('beforeend','<div class="row">' +
          '<p><div class="col-5 col-lg-2">' +
          '<label>Slug</label>' +
          '<input class="form-control" type="text" name="tags_eng[]" value="" required>' +
          '</div>' +
          '<div class="col-5 col-lg-2">' +
          '<label>Название</label>' +
          '<input class="form-control" type="text" name="tags_rus[]" value="" required>' +
          '</div>' +
          '<div class="col-2 col-lg-1"><br>' +
          '<button class="btn btn-secondary removeTagsRow" style="background: ' + randomColor + ' !important;" >-</button>' +
          '</div>' +
          '</p></div>')


        const removeTags = document.querySelectorAll('.removeTagsRow');
        const lastElement = Array.from(removeTags).slice(-1)[0];

        lastElement.addEventListener('click', (event)=>{
          event.preventDefault();
          lastElement.parentElement.parentElement.remove();

          galleryItems.forEach(el=>{
            const tags = el.querySelectorAll('.tag');
            Array.from(tags).slice(-1)[0].remove();
          })
        })

        const galleryItems = document.querySelectorAll('.number');

        galleryItems.forEach((el)=>{
          el.insertAdjacentHTML('beforeend', '<div class="tag"><input name="" type="checkbox" style="box-shadow: 0 0 5px  ' + randomColor + '"/></div>')
        })

      });


    }




    galleryUpdate.addEventListener('click', () => {

      const tags_eng = document.getElementsByName('tags_eng[]');
      const tags_rus = document.getElementsByName('tags_rus[]');


      const tags = [];
      for(let i=0; i<tags_eng.length; i++){
        tags.push({
          slug: tags_eng[i].value,
          name: tags_rus[i].value
        });
      }

      const content =[];


      const galleryImages = document.querySelectorAll('.number');

      Array.from(galleryImages).forEach((el)=>{


      let tag = null;
      let elCount = 0;
      Array.from(el.querySelectorAll('input')).forEach(el=>{
        if(el.checked){
          tag = elCount;
        }
        elCount++;
      })

      content.push({img: el.innerText,
                    tag: tag})

      })

      const galleryNew = {
        title: galleryTitle.value,
        desc: galleryDescription.value,
        thumb: galleryThumb.value,
        tags: tags,
        content: content
      };


        let payload = {
          data: {
            method: 'updateTaggedGallery',
            gallery: galleryName.innerText,
            content: galleryNew
          }
        };

      requestAPI('./api.php','POST', payload).then(
        (result) => {
          console.log(result)
        });


    }
    )


    let payload = {
      data: {
        method: 'fetchTaggedGallery',
        gallery: galleryName.innerText
      }
    };

    requestAPI('./api.php','POST', payload).then(
      (result) => {
        if(result.result){

          galleryTitle.value = result.gallery.title;
          galleryDescription.value = result.gallery.desc;
          galleryThumb.value = result.gallery.thumb;


          let colors =[];
          result.gallery.tags.forEach((el)=>{



            const randomColor = getRandomColor();

            colors.push(randomColor);
            const tagsForm = document.getElementById('tagsForm');
            tagsForm.insertAdjacentHTML('beforeend','<div class="row">' +
              '<p><div class="col-5 col-lg-2">' +
              '<label>Slug</label>' +
              '<input class="form-control" type="text" name="tags_eng[]" value="' + el.slug + '" required>' +
              '</div>' +
              '<div class="col-5 col-lg-2">' +
              '<label>Название</label>' +
              '<input class="form-control" type="text" name="tags_rus[]" value="' + el.name + '" required>' +
              '</div>' +
              '<div class="col-2 col-lg-1"><br>' +
              '<button class="btn btn-secondary removeTagsRow" style="background: ' + randomColor + ' !important;" >-</button>' +
              '</div>' +
              '</p></div>')

          });


          result.gallery.content.forEach((el)=>{
            let tagsChecksBox = '';
            let tagsCount = 0;
            result.gallery.tags.forEach(()=>{
              tagsChecksBox = tagsChecksBox + '<div class="tag" ><input ' + (el.tag === tagsCount ? 'checked=""' : '') + ' type="checkbox" style="box-shadow: 0 0 5px  ' + colors[tagsCount] + ';"></div>';
              tagsCount++;
            })

            document.querySelector('.gallery__list').insertAdjacentHTML('beforeend','' +
              '<div class="gallery__item">' +
              '<div class="number">' + el.img + '' + tagsChecksBox +
              '</div>' +
              '<img src="/photos/' +galleryName.innerText + '/thumbs/' + el.img + '">' +
              '</div>')

          })


      }
    });
  }














})