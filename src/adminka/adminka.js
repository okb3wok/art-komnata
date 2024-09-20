document.addEventListener('DOMContentLoaded', ()=>{


 console.log('[:-)] Loading js scripts!');


 let tagsForm = document.getElementById('tagsForm');
 if(tagsForm){


  let addTags = document.getElementById('addTags');
  addTags.addEventListener('click', (event)=>{
    event.preventDefault();

    function getRandomColor() {
      const r = Math.floor(Math.random() * 256);
      const g = Math.floor(Math.random() * 256);
      const b = Math.floor(Math.random() * 256);
      return `rgb(${r}, ${g}, ${b})`;
    }


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






})