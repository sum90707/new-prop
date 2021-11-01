$(function() {
    var bannerList = ['https://cdn.holmesmind.com/image/defbg.jpg',  
                      'https://cdn.holmesmind.com/image/defbg.jpg',
                      'https://cdn.holmesmind.com/image/defbg.jpg'],
      $imgGroup = $('#img-group'),
      imgHtml = $('#img-group').html();


    function creatBannerCycle() {


      for(let urlIndex in bannerList){
        let imgTemplate = stringReplace(imgHtml, {'%%IMG_URL%%' : bannerList[urlIndex]});

        imgTemplate = stringReplace(imgTemplate, {'%%index%%': urlIndex})
        $imgGroup.append(imgTemplate)
      }

      setCycle();
    }

    function setCycle() {
      $('#img-group').cycle({
          slideResize: false,
          containerResize: true,
          width: '100%',
          height: '400px',
          fx: 'scrollHorz',
          next: '#right',
          prev: '#left'
        });
    }
    
    $imgGroup.html('');
    creatBannerCycle();
  })