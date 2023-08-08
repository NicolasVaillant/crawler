fetch('resources/php/main.php')
    .then(response => response.json())
    .then(data => {
        console.log(data)
        printData(data)
    })
    .catch(error => {
        // Handle any errors that occurred during the request
        console.error(error);
    });

const printData = function (data) {
    Object.values(data).forEach(e => {
        if(e === "") return
        const result = JSON.parse(e)
        // console.log(result)
        documentWrite(result)
    });
}
// printData(data)
const documentWrite = function (data) {
    const array = data[0]
    if (array.error) return
    const container = document.createElement('article')
    const col_img = document.createElement('div')
    const col_text = document.createElement('div')
    const img = document.createElement('img')
    const site = document.createElement('span')
    const title = document.createElement('h1')
    const description = document.createElement('p')
    const category = document.createElement('span')
    const time = document.createElement('span')

    // img.style.backgroundImage = `url(${array.img})`
    img.src = array.img
    site.classList.add('from')
    site.innerText = array.site
    title.innerText = array.title
    category.classList.add('category')
    category.innerText = array.category
    time.innerText = array.time

    if ('text' in array) {
        description.innerText = array.text
    }

    col_img.classList.add('col-img')
    col_img.appendChild(img)
    col_text.classList.add('col-text')
    col_text.appendChild(site)
    col_text.appendChild(title)
    col_text.appendChild(description)
    col_text.appendChild(category)
    col_text.appendChild(time)

    container.appendChild(col_img)
    container.appendChild(col_text)
    document.querySelector('.wrapper-content').appendChild(container)
}