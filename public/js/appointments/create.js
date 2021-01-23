let $doctor, $date, $speciality, $hours;
let iRadio;
const noHoursAlert = `<div class="alert alert-danger" role="alert">
    <strong>Lo sentimos</strong> No se encontraron horas disponibles para el médico en el día seleccionado
</div>`
$(function (){

  $speciality = $('#speciality');
  $doctor = $('#doctor');
  $date= $('#date');
  $hours = $('#hours');

  $speciality.change(() => {
    const specialityId = $speciality.val();
    const url = `/specialities/${specialityId}/doctors`;

    $.getJSON(url, onDoctorsLoaded);
  });

  $doctor.change(loadHours);
  $date.change(loadHours);

});


function onDoctorsLoaded(doctors) {
  let htmlOptions ='';
   doctors.forEach(doctor =>{
    htmlOptions +=`<option value="${doctor.id}">${doctor.name}</option>`;
   });
   $doctor.html(htmlOptions);
   loadHours();//side defect
  }

 function loadHours(){
    const selectedDate = $date.val();
    const doctorId = $doctor.val();
    const url = `/schedule/hours?date=${selectedDate}&doctor_id=${doctorId}`;
    $.getJSON(url, displayHours);
 }

 function displayHours(data){
  if (!data.morning && !data.afternoon) {
      $hours.html(noHoursAlert);
      return;
  }
  
  let htmlHours = '';
  iRadio = 0;
  if(data.morning){
    const morning_intervals = data.morning;
    morning_intervals.forEach(interval =>{
      htmlHours += getRadionIntervalHtml(interval);
    });
  }

  if(data.afternoon){
    const afternoon_intervals = data.afternoon;
    afternoon_intervals.forEach(interval =>{
      htmlHours += getRadionIntervalHtml(interval);
    });
  }

  $hours.html(htmlHours);

 }

 function getRadionIntervalHtml(interval){
  const text = `${interval.start} - ${interval.end}`;
  return `<div class="custom-control custom-radio mb-3">
  <input type="radio" id="interval${iRadio}" name="scheduled_time" class="custom-control-input" value="${interval.start}" required>
  <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
  </div>`
 }