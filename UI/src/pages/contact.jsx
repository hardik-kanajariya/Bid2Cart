import React, {useEffect, useState} from "react";
import Breadcrumb from "../components/common/Breadcrumb";
import Preloader from "../components/common/Preloader";
import ContactInfo from "../components/contact/ContactInfo";
import Layout from "../components/layout/Layout";

function ContactPage() {
    const [isLoaded, setIsLoaded] = useState(true)
    useEffect(() => {
        setIsLoaded(false)
    }, [])
    return (<>
            {isLoaded ? (<Preloader classText="preloader"/>) : (<Layout>
                <Breadcrumb pageName="Contact Us" pageTitle="Contact Us"/>
                <ContactInfo/>
            </Layout>)}
        </>);
}

export default ContactPage;
