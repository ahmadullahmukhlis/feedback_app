export default ({ urlPath, redirect }) => {
    const token = localStorage.getItem('token')
    const isAuthorized = !!token
    if (!isAuthorized && !urlPath.includes('login')) {
        redirect({ path: '/login' })
        return
    }
    // ...
}
