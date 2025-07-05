import React, {useEffect, useState} from "react";
import About from "../components/about/About";
import WhyChooseUs from "../components/about/WhyChooseUs";
import Breadcrumb from "../components/common/Breadcrumb";
import Layout from "../components/layout/Layout";
import Preloader from "../components/common/Preloader";

function AboutPage() {
    const [isLoaded, setIsLoaded] = useState(true)
    useEffect(() => {
        setIsLoaded(false)
    }, [])
    return (
        <>
            {isLoaded ? (
                <Preloader classText="preloader"/>
            ) : (<Layout>
                <Breadcrumb pageName="About Us" pageTitle="About Us"/>
                <About/>
                <WhyChooseUs/>
                {/* <Testimonial /> */}
            </Layout>)}
        </>

    );
}

export default AboutPage;
