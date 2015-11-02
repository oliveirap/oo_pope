$(document).ready(function(){
	$('#buscar').on("click", getQuestions(event));

	function getQuestions(event)
	{
		var tagsArr = [];
		var difArr  = [];
		var def = 	"<tr><td>Usar</td><td>Enunciado</td><td>Alternativas</td>"  +
					"<td>Correta</td>/tr>"
		var table = $('#qholder table');
		$('.tagCheck:checked').each(function(i){
			tagsArr[i] = $(this).val();
		});

		$('.difCheck:checked').each(function(i){
			difArr[i] = $(this).val();
		});
		$.ajax({
			url: "http://pope.dev/oo_pope/www/assets/partials/search.php?action=1",
			beforeSend: function(){
				table.html(def + "<tr><td colspan='4' style='text-align: center'>Carregando</td></tr>");
			},
			cache: false,
			method: "POST",
			data: {tags: tagsArr, diff: difArr},
			dataType: "json",
			success: function(data){
					var code;
				if(!jQuery.isEmptyObject(data))
				{
					table.html(def);
					$.each(data.questions, function(key, q){
						code = 	"<tr><td><input type='checkbox' name='testQuestions[]'"+
								" value='" + q.id + "'></td><td>" + q.body + "</td>"   +
								"<td>" + q.answers + "</td><td>" + convertLetter(q.correct_answer)    +
								"</td></tr>"  
						table.append(code);
					});
				}
				else
				{
						code = def + "<tr><td colspan=4>Nenhuma questão encontrada com estes critérios.</td></tr>"
						table.html(code);
				}
			}
		});
		event.preventDefault();
	}
	// Converts alt-N to letter alternatives
	function convertLetter(alt)
	{
		switch(alt)
		{
			case "alt-1": 
				return "A";
				break;
			case "alt-2": 
				return "B";
				break;
			case "alt-3": 
				return "C";
				break;
			case "alt-4": 
				return "D";
				break;
			case "alt-5": 
				return "E";
				break;
		}
	}

	function paginateQuestions($data, $perPage, $page)
	{
		
	}

});