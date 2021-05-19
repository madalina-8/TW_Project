const jsdom = require('jsdom');
const dom = new JSDOM(`<!DOCTYPE html><body><p id="main">My First JSDOM!</p></body>`);
console.log(dom.window.document.getElementById("main").textContent);

/*
const { JSDOM } = require("jsdom")
const axios = require('axios')


const dom = new JSDOM(`<!DOCTYPE html><p>Hello world</p>`);
console.log(dom.window.document.querySelector("p").textContent); // "Hello world"
/!*
const upvoteFirstPost = async () => {
    try {
        const { data } = await axios.get("https://old.reddit.com/r/programming/");
        const dom = new JSDOM(data, {
            runScripts: "dangerously",
            resources: "usable"
        });
        const { document } = dom.window;
        const firstPost = document.querySelector("div > div.midcol > div.arrow");
        firstPost.click();
        const isUpvoted = firstPost.classList.contains("upmod");
        const msg = isUpvoted
            ? "Post has been upvoted successfully!"
            : "The post has not been upvoted!";

        return msg;
    } catch (error) {
        throw error;
    }
};

upvoteFirstPost().then(msg => console.log(msg));*!/
*/
