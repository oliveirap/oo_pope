$(document).ready(function(){
	var question = [];
	$('#buscar').on("click", function(event){
		getQuestions(event, 1);
	});
	$(document.body).on("click", "#linkholder a", function(event){
		$page = $(this).attr('href').substring(6);
		getQuestions(event, $page);
	});

	$('#qholder').on("change", ".checkbox-question", function(){
		var checkbox = this;
		if(this.checked)
		{
			question.push(this.value);
		}
		else
		{
			question = $.grep(question, function(n,i){
				return (n !== checkbox.value)
			});
		}
	});
	
	$("#newTest").submit(function(e){
		html = "";
		$.each(question, function(index,value){
			html += "<input type='hidden' name='theQuestions[]' value='" + value + "'>";
		});
		$(this).append(html);
		return true;
	});

	function getQuestions(event, page)
	{
		event.preventDefault();
		if(page === undefined)
		{
			page = 1;
			}
		var tagsArr = [];
		var difArr  = [];
		var def = 	"<tr><td>Usar</td><td>Enunciado</td><td>Alternativas</td>"  +
					"<td>Correta</td>/tr>"
		var table = $('#qholder table');
		var linkdiv = $('#linkholder');
		var url = "http://pope.dev/oo_pope/www/assets/partials/search.php?action=1&page=" + page;
		$('.tagCheck:checked').each(function(i){
			tagsArr[i] = $(this).val();
		});

		$('.difCheck:checked').each(function(i){
			difArr[i] = $(this).val();
		});
		$.ajax({
			url: url,
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
						code = 	"<tr><td><input type='checkbox' class='checkbox-question' name='testQuestions[]'"+
								" value='" + q.id + "'></td><td>" + q.body + "</td>"   +
								"<td>" + q.answers + "</td><td>" + convertLetter(q.correct_answer)    +
								"</td></tr>"  
						table.append(code);
					});
					linkdiv.html(data.links);
				}
				else
				{
						code = def + "<tr><td colspan=4>Nenhuma questão encontrada com estes critérios.</td></tr>"
						table.html(code);
				}
			}
		});
		return false;
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
});