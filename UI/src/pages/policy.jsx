import React, {useEffect, useState} from 'react'
import Layout from '../components/layout/Layout'
import Preloader from "../components/common/Preloader";

export default function Policy() {
    const [html, setHtml] = useState("")
    const [isLoaded, setIsLoaded] = useState(true)
    useEffect(() => {
        const fetchPolicy = async () => {
            const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/api/policy`);
            const data = await res.json()
            setHtml(data.data)
        }
        fetchPolicy().then(r => setIsLoaded(false));
    }, [])

    return isLoaded ? <>
        <Preloader/>
    </> : (<Layout>
            <div className="container">
                <h1 className='text-center mt-2 mb-2'>Privacy Policy</h1>
                <hr/>
                <p className='para' dangerouslySetInnerHTML={{__html: html}}></p>
            </div>
        </Layout>)
}
