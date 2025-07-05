import React, {useEffect, useState} from 'react';
import Image from 'next/image';
import Carousel from 'react-bootstrap/Carousel';

function Banner() {
    const [item, setItem] = useState([]);

    useEffect(() => {
    }, [])

    // Custom image loader
    const customImageLoader = ({src}) => {
        return src;
    }
    return (
        <>

            <Carousel>
                <Carousel.Item>
                    <div style={{
                        width: "100%",
                        height: "300px",
                    }}>
                        <Image loader={customImageLoader} className="d-inline-block w-100" layout="fill"
                               src="https://picsum.photos/720/300" alt="First slide"/>
                    </div>
                    <Carousel.Caption>
                        <h2>Something Ad Title</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias dicta nam dolorem aspernatur!
                            Voluptas facere animi veritatis sequi dolorum. Corporis.</p>
                    </Carousel.Caption>
                </Carousel.Item>
                <Carousel.Item>
                    <div style={{
                        width: "100%",
                        height: "300px",
                    }}>
                        <Image loader={customImageLoader} className="d-inline-block w-100" layout="fill"
                               src="https://picsum.photos/720/300" alt="First slide"/>
                    </div>
                    <Carousel.Caption>
                        <h2>Something Ad Title</h2>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laudantium quod eum saepe fuga eius
                            quos nesciunt temporibus ipsum quaerat veniam?</p>
                    </Carousel.Caption>
                </Carousel.Item>
            </Carousel>
        </>
    )
}

export default Banner