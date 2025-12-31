import { boot } from 'quasar/wrappers'
import html2canvas from 'html2canvas'
const printFunction = id => {
    const element = document.getElementById(id) // Replace with your element's ID
    html2canvas(element).then(canvas => {
        const imageData = canvas.toDataURL('image/png')
        const printWindow = window.open()
        const image = `<img src='${imageData}' width='100%' />`
        printWindow.document.write(
            `<html><head><title>Print</title></head><body style='padding: 0; margin: 0;'>${image}</body></html>`,
        )
        // Step 5: Print the New Window with a Delay
        setTimeout(() => {
            printWindow.print()
            printWindow.close()
        }, 1000)
    })
}

export default boot(({ app }) => {
    app.config.globalProperties.$print = printFunction
})
