$(document).ready(function(){

    // if the user clicks on the like button ...
    $('.like-btn').on('click', function(){
      var post_id = $(this).data('id');
      console.log(post_id);
      $clicked_btn = $(this);
      if ($clicked_btn.hasClass('fa-thumbs-o-up')) {
          action = 'like';
      } else if($clicked_btn.hasClass('fa-thumbs-up')){
          action = 'unlike';
      }
      $.ajax({
          url: 'index.php',
          type: 'post',
          data: {
              'action': action,
              'post_id': post_id
          },
          success: function(data){
              res = JSON.parse(data);
              if (action == "like") {
                  $clicked_btn.removeClass('fa-thumbs-o-up');
                  $clicked_btn.addClass('fa-thumbs-up');
              } else if(action == "unlike") {
                  $clicked_btn.removeClass('fa-thumbs-up');
                  $clicked_btn.addClass('fa-thumbs-o-up');
              }
              // display the number of likes and dislikes
              $clicked_btn.siblings('span.likes').text(res.likes);
              $clicked_btn.siblings('span.dislikes').text(res.dislikes);
    
              // change button styling of the other button if user is reacting the second time to post
              $clicked_btn.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
          }
      });		
    
    });
    
    // if the user clicks on the dislike button ...
    $('.dislike-btn').on('click', function(){
      var post_id = $(this).data('id');
      $clicked_btn = $(this);
      if ($clicked_btn.hasClass('fa-thumbs-o-down')) {
          action = 'dislike';
      } else if($clicked_btn.hasClass('fa-thumbs-down')){
          action = 'undislike';
      }
      $.ajax({
          url: 'index.php',
          type: 'post',
          data: {
              'action': action,
              'post_id': post_id
          },
          success: function(data){
              res = JSON.parse(data);
              if (action == "dislike") {
                  $clicked_btn.removeClass('fa-thumbs-o-down');
                  $clicked_btn.addClass('fa-thumbs-down');
              } else if(action == "undislike") {
                  $clicked_btn.removeClass('fa-thumbs-down');
                  $clicked_btn.addClass('fa-thumbs-o-down');
              }
              // display the number of likes and dislikes
              $clicked_btn.siblings('span.likes').text(res.likes);
              $clicked_btn.siblings('span.dislikes').text(res.dislikes);
              
              // change button styling of the other button if user is reacting the second time to post
              $clicked_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
          }
      });	
    
    });
   
	// When user clicks on submit reply to add comment under post
	// $(document).on('click', '.comment-btn', function(e){
	// 	e.preventDefault();
	// 	var post_id = $(this).data('id');
	// 	console.log(post_id);
	// 	$(this).parent().siblings('form#comment_form_' + post_id).toggle(500);
	// 	console.log("hahah");
		// When user clicks on submit comment to add comment under post
		$(document).on('click', '#submit_comment', function(e)  {
			e.preventDefault();
			var post_id = $(this).data('id');
			console.log(post_id);
			var comment_text = $('#comment_text_'+post_id).val();
			var url = $('#comment_form_'+ post_id).attr('action');
			// Stop executing if not value is entered
			console.log(comment_text);
			if (comment_text === "" ) return;
			$.ajax({
				url: url,
				type: "post",
				data: {
					post_id:post_id,
					comment_text: comment_text,
					comment_posted: 1
				},
				
				success: function(data){
                    console.log(data);
					var response = JSON.parse(data);
					if (data === "error") {
						alert('There was an error adding comment. Please try again');
					} else {
						$('#comments_wrapper_'+ post_id).prepend(response.comment);
						 $('#comments_count_'+ post_id).text(response.comments_count); 
						$('#comment_text').val('');
					}
				}
			});
		});
	// });
	// When user clicks on submit reply to add reply under comment
	$(document).on('click', '.reply-btn', function(e){
		e.preventDefault();
		// Get the comment id from the reply button's data-id attribute
        var comment_id = $(this).data('id');
        console.log(comment_id);
		// show/hide the appropriate reply form (from the reply-btn (this), go to the parent element (comment-details)
		// and then its siblings which is a form element with id comment_reply_form_ + comment_id)
		$(this).parent().siblings('form#comment_reply_form_' + comment_id).toggle(500);
		$(document).on('click', '.submit-reply', function(e){
			e.preventDefault();
			// elements
             var reply_textarea = $(this).siblings('textarea'); // reply textarea element
             var reply_text = $(this).siblings('textarea').val();
            // var reply_text = $('#reply_text').val();

            // console.log(reply_text);

            var url = $(this).parent().attr('action');

			$.ajax({
				url: 'comment.php',
                type: "POST",
				data: {
					comment_id: comment_id,
					reply_text: reply_text,
					reply_posted: 1
				},
			
                
				success: function(data){
                    console.log(data);
					if (data === "error") {
						alert('There was an error adding reply. Please try again');
					} else {
						$('.replies_wrapper_' + comment_id).append(data);
						reply_textarea.val('');
					}
				}
			});
		});
	});
       
});