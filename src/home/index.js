/**
 * 
 * @param {string} requestMethod GET|POST|PUT|DELETE...
 * @param {string} url API endpoint
 * @param {object} body request body
 * @param {function} onLoad function to call on success 
 * @param {function} onError function to call on error
 */
const APIRequest = (
    requestMethod, url,
    body = null,
    onLoad = () => alert("OK"),
    onError = () => alert("Error!")
) => {

    let request = new XMLHttpRequest();

    request.open(requestMethod, url);
    request.setRequestHeader("Authorization", "Basic " + btoa(`${user.username}:${user.password}`));
    request.send(JSON.stringify(body));

    request.addEventListener("load", () => {
        try {
            var o = JSON.parse(request.response);
            onLoad(request.response);
        } catch (e) {
            onError();
        }
    });
}

// blogfeed list

class BlogFeed {

    static domObj = document.getElementById("blogfeed");
    static map = new Map();

    static addBlog(id, time, author, content) {
        let obj = { time, author, content };
        if (this.map.has(id)) return;
        this.map.set(id, obj);
        //alert(this.map.get(id).content);

        let child = document.createElement("div");
        child.id = id; child.className = "blogpost";
        child.innerHTML = `
            <p>
                <span class="author">${author}</span>
                <span class="time">@${time}</span>
            </p>
            <p class="content">${content}</p>
        `;

        //if (this.map.size > 0)
        //this.domObj.appendChild(child);
        this.domObj.prepend(child);
    }

    static updateFeed() {

        //console.log("updateFeed call");
        APIRequest("GET", "http://localhost:3001/api/blogposts/",
            null,
            (response) => {
                for (let obj of JSON.parse(response)) {
                    let { id, posttime, poster, content } = obj;
                    this.addBlog(id, posttime, poster, content);
                }
            }
        );
    }
}

var updateTimer = setInterval(() => BlogFeed.updateFeed(), 1000);

// posting form onload
document.getElementById("postButton").onclick = () => {

    let textarea = document.getElementById("postingForm_content");

    APIRequest("POST", "http://localhost:3001/api/blogposts/",
        { content: textarea.value },
        (response) => { BlogFeed.updateFeed(); }
    );
    textarea.value = "";
}