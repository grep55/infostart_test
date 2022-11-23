$( document ).ready(function() {


	function GetURLParameter(sParam)
	{
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++) 
		{
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam) 
			{
				return sParameterName[1];
			}
		}
	}

	var fioSort = GetURLParameter('UF_FIO');
	var dateSort = GetURLParameter('UF_DATE');

	// Placeholder у сортировки ФИО
	if(GetURLParameter('UF_FIO')) {
		if (fioSort != 'Не выбрано') {
			$("#fioSelect").val(fioSort).change();
		}else{
			$("#fioSelect").val('none').change();
		}
	}

	// Placeholder у сортировки даты
	if(GetURLParameter('UF_DATE')) {
		if (dateSelect != 'Не выбрано') {
			$("#dateSelect").val(dateSort).change();
		}else{
			$("#dateSelect").val('none').change();
		}
	}

	// Example starter JavaScript for disabling form submissions if there are invalid fields / С BootStrap`а
	(function() {
	  'use strict';
	  window.addEventListener('load', function() {
		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		var forms = document.getElementsByClassName('needs-validation');
		// Loop over them and prevent submission
		var validation = Array.prototype.filter.call(forms, function(form) {
		  form.addEventListener('submit', function(event) {
			if (form.checkValidity() === false) {
			  event.preventDefault();
			  event.stopPropagation();
			}
			form.classList.add('was-validated');
		  }, false);
		});
	  }, false);
	})();


		$("#form").submit(function (e) { // Устанавливаем событие отправки для формы с id=form

			var form_data = $(this).serialize(); // Собираем все данные из формы
			e.preventDefault();

			var user_fio    = $('#InputFio').val();
			var user_email   = $('#InputEmail').val();
			var user_question = $('#InputQuestion').val();
			var user_tel = $('#InputTel').val();

			// Проверяем данные на заполненость
			if( user_fio && user_email && user_question ){

				$.ajax({
					type: "POST", // Метод отправки
					url: "/feedbackform/script/send.php", // Путь до php файла отправителя
					data: form_data,
					success: function (result) {
						// Код в этом блоке выполняется при успешной отправке сообщения
						$( "#alertBlock" ).html(result);
						$( "#alertBlock" ).show();
						$( "#form" ).hide();

						//Не забываем про вывод в табличке
						$('#resultTable > tbody').prepend('<tr><th scope="row">'+ user_fio + '</th><td>'+ user_email + '</td><td>'+ user_tel + '</td><td>'+ user_question + '</td></tr>');
						$('#resultTable > tbody > tr:last-child').remove();

						const myTimeout = setTimeout(illBeBack, 5000);
						function illBeBack() {
							$( "#alertBlock" ).hide();
							$( "#form" ).show();
							$( "#form" ).reset();
						}
					}
				});
			}
        });
});

