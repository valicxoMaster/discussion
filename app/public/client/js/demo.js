$(function(){
var getCommentHtml = function(item) {
    
    var userEmail = $("#user-email").val();
    
    var html = "<div class='comment-container'>";
    html += "<div class='comment-box'>";    
    html += "<div class='comment-item comment-user'>";
    
    html += "<div>";
    html += "<div class='user-email'>" + item.email + "</div>";
    html += "</div>";

    html += "<div>";
    html += "<div class='user-name'>" + item.userName + "</div>";
    html += "</div>";

    html += "<div class='comment-item comment-action-panel' id='cdid-" + item.id + "' >";
    
    if (userEmail === item.email){
        
        html += "<div><input type='button' class='btn-action btn-edit' value='change'></div>";
        html += "<div><input type='button' class='btn-action btn-delete' value='delete'></div>";        
    }
    
    html += "</div>";    
    html += "</div>";
    
    html += "<div class='comment-item comment-text'>" + item.content;
    html += "</div>";    
    
    html += "</div>";
    html += "<div class='error-message'></div>";    
    html += "</div>";
    return html;    
};

var getCommentProps = function() {
    return ['id', 'articleId', 'userId', 'enabled', 'updated', 'userName', 'email', 'content'];
};

var loadList = function(articleId) {
    
    var props = getCommentProps();
    $.get( "/comment/list/" + articleId, function(data) {
        
        $("#app-comment-list").html("");
        data.forEach(function(item) {
            
            $("#app-comment-list").append(getCommentHtml(item));
            var selector = "#cdid-" + item.id;
            
            props.forEach(function(prop) {
                $(selector).data(prop, item[prop]);                
            });
        });        
    });    
};

$(document).on("blur", "#user-email", function() {
    loadList($("#content").data("article-id"));
});

$(document).ready(function() {
    loadList($("#content").data("article-id"));
});     

$(document).on("click", "#new-comment-send", function() {

    var input = {
        email: $("#user-email").val(),
        userName: $("#user-name").val(),
        content: $("#text-comment").val()
    };
    
    if (input.email !== '' && input.userName !== '' && input.content !== '') {
        $.ajax("/comment/add/" + $("#content").data("article-id"), {
            data : JSON.stringify(input),
            contentType : 'application/json',
            type : 'POST',
            success: function(data) {
                loadList($("#content").data("article-id"));
            },
            statusCode: {
                400: function() {
                    $("#error-message").html("Comment has not been saved.");
                }
            }
        });
    }
});


$(document).on("click", ".btn-delete", function() {
    
    var storageElm = $(this);
    var storage = $(this).parents(".comment-action-panel").data();

    $.ajax("/comment/delete/" + $("#content").data("article-id"), {
        data : JSON.stringify(storage),
        contentType : 'application/json',
        type : 'DELETE',
        success: function(data) {
            loadList($("#content").data("article-id"));
        },
        statusCode: {
            400: function() {
                var err = storageElm.parents(".comment-container").find(".error-message");
                err.html("Comment has not been deleted.");
            }
        }
    });
});

$(document).on("click", ".btn-edit", function() {
    
    var container = $(this).parents(".comment-container").find(".comment-text");
    var txt = container.html();
    
    var html = "<div class='comment-box curent-comment-text'>";
    html += "<div>";
    html += "<textarea maxlength='300' class='text-current-comment'>" + txt + "</textarea>";    
    html += "</div>";
    
    html += "<div>";
    html += "<input type='button' value='send' class='btn-current-edit'>";
    html += "</div>";    
    
    html += "</div>";
    container.html(html);
});

$(document).on("click", ".btn-current-edit", function() {
    
    var storageElm = $(this).parents(".comment-container");
    var textArr = storageElm.find(".text-current-comment");
    var content = textArr.val();    
    textArr.hide();
    
    var storage = storageElm.find(".comment-action-panel").data();    
    storage.content = content;
    
//    storageElm.find(".comment-text").html(content);

    $.ajax("/comment/update/" + $("#content").data("article-id"), {
        data : JSON.stringify(storage),
        contentType : 'application/json',
        type : 'PUT',
        success: function(data) {
            loadList($("#content").data("article-id"));
        },
        statusCode: {
            400: function() {
                var err = storageElm.parents(".comment-container").find(".error-message");
                err.html("Comment has not been saved.");
            }
        }
    });
});
    
}());