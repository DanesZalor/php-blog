/**
 * 
 * @param {string} requestMethod 
 * @param {string} url 
 * @param {function} onLoad 
 */
const APIRequest = (requestMethod, url, onLoad) => {

    let request = new XMLHttpRequest();
    request.open(requestMethod, url);
    request.send();

    request.onload = () => onLoad(request.response);
}


// blogfeed list

class BlogFeed {

    static domObj = document.getElementById("blogfeed");
    static map = new Map();

    static addBlog(id, time, author, content) {
        let obj = { time, author, content };
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
        this.domObj.appendChild(child);
    }

    static updateFeed() {
        APIRequest("GET", "http://localhost:3001/api/blogposts/", (response) => {
            for (let obj of JSON.parse(response)) {
                let { id, posttime, poster, content } = obj;
                this.addBlog(id, posttime, poster, content);
            }
        });
    }
}

var updateTimer = setTimeout(() => BlogFeed.updateFeed(), 1000);


// posting form onload

document.getElementById("postButton").onclick = () => {
    //APIRequest("POST")
    alert("fuck off");
}