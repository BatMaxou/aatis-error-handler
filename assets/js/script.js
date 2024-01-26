const traceHeaders = document.querySelectorAll('.trace-header')

const findParent = (el, cls) => {
    while (!el.classList.contains(cls)) {
        el = el.parentElement
    }

    return el
}

const handleClick = (e) => {
    const traceHeader = findParent(e.target, 'trace-header')
    const chevron = traceHeader.querySelector('.chevron')
    const traceContext = traceHeader.nextElementSibling

    chevron.classList.toggle('active')
    traceContext.classList.toggle('active')
}

traceHeaders.forEach((traceHeader) => {
    traceHeader.addEventListener('click', (e) => handleClick(e))
})
