async function loadSvg(svgUrl) {return fetch(svgUrl).then(res => {return res.text()});}

async function setSvg(svgElement){
    if (svgElement.getAttribute('src')) {
        const tempElement = document.createElement('div');
        tempElement.innerHTML = await loadSvg(svgElement.getAttribute('src'))

        const tempSvgElement = tempElement.querySelector('svg');

        if (tempSvgElement) {
            if (tempSvgElement.getAttribute('viewBox')) {
                svgElement.setAttribute("viewBox", tempSvgElement.getAttribute('viewBox'));
            }
            if (tempSvgElement.getAttribute('xmlns')) {
                svgElement.setAttribute("xmlns", tempSvgElement.getAttribute('xmlns'));
            }

            svgElement.innerHTML = ""
            tempSvgElement.querySelectorAll('path').forEach(function(pathElement) {
                svgElement.appendChild(pathElement);
            });
        }
    }
}

document.querySelectorAll('svg').forEach(function(svgElement) {
    if (svgElement.getAttribute('src')) {
        setSvg(svgElement);
        const observer = new MutationObserver(mutationsList => {
            mutationsList.forEach(mutation => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'src') {
                    setSvg(mutation.target);
                }
            });
        });
        observer.observe(svgElement, {attributes: true});
    }
})