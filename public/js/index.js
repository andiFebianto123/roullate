//your own function to capture the spin results
function myResult(e) {
  //e is the result object
    console.log(e);
    console.log('Spin Count: ' + e.spinCount + ' - ' + 'Win: ' + e.win + ' - ' + 'Message: ' +  e.msg);

    // if you have defined a userData object...
    if(e.userData){
      var token = $('meta[name="csrf-token"]').attr('content');

      $.post( "reduce-stock", { _token: token, id: e.userData.id, name: e.msg })
      .done(function( response ) {
        if (response.status) {
          Swal.fire({
            title: 'Selamat',
            text: response.message,
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#d7322d',
            confirmButtonText: 'Tutup'
          }).then((result) => {
          })
          
        }else{
          console.log(response.message);
        }
      });
    }

}

//your own function to capture any errors
function myError(e) {
  //e is error object
  console.log('Spin Count: ' + e.spinCount + ' - ' + 'Message: ' +  e.msg);

}

function myGameEnd(e) {
  
  //e is gameResultsArray
  console.log(e);
  //reset the wheel at the end of the game after 5 seconds
  /* TweenMax.delayedCall(5, function(){
    
    Spin2WinWheel.reset();

  })*/


}


function init() {

  loadJSON(function(response) {
    // Parse JSON string to an object
    var jsonData = JSON.parse(response);
    //if you want to spin it using your own button, then create a reference and pass it in as spinTrigger
    var mySpinBtn = document.querySelector('.spinBtn');
    //create a new instance of Spin2Win Wheel and pass in the vars object
    var myWheel = new Spin2WinWheel();
    
    //WITH your own button
    myWheel.init({data:jsonData, onResult:myResult, onGameEnd:myGameEnd, onError:myError, spinTrigger: mySpinBtn});

    var labels = $('.valueContainer').children();
    var fills = jsonData.fillColors;

    for (let i = 0; i < fills.length; i++) {
      labels.eq(i).children().attr('fill', fills[i]);
      labels.eq(i).children().attr('y', '190');

      labels.eq(i).css({
        'writing-mode': 'vertical-lr',
        'text-orientation': 'mixed',
        'text-transform': 'uppercase',
        'font-weight':'900',
        'margin-left':'80px',
      });
      // console.log(labels.eq(i).children());
    }

    // console.log(labels, jsonData);
    
    //WITHOUT your own button
    // myWheel.init({data:jsonData, onResult:myResult, onGameEnd:myGameEnd, onError:myError});
  });
}



//And finally call it
init();
