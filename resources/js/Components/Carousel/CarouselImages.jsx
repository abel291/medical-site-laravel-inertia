import React from 'react'
import CarouselContainer from './CarouselContainer'
import { SwiperSlide } from 'swiper/react'
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/react/16/solid'
import { Navigation, Pagination } from 'swiper/modules'

const CarouselImages = ({ images }) => {
    return (
        images.length > 1 ? (

            <div className='relative px-10'>

                <CarouselContainer
                    loop={true}
                    modules={[Navigation, Pagination]}
                    slidesPerView={1}
                    spaceBetween={15}
                    centeredSlides={true}
                    pagination={true}
                    navigation={{
                        nextEl: ".button-next-image",
                        prevEl: ".button-prev-image",
                    }}
                    breakpoints={{
                        768: {
                            slidesPerView: 1.4,
                            spaceBetween: 20,

                        },
                        1024: {
                            slidesPerView: 1.6,
                            spaceBetween: 20,

                        },

                    }}>
                    {
                        images.map((image) => (
                            <SwiperSlide className={" relative mb-10"} key={image.id} >
                                <ImageCarousel image={image} />
                            </SwiperSlide>
                        ))
                    }

                </CarouselContainer >

                <div className='absolute inset-x-0 top-1/2 z-10  '>
                    <div className='flex justify-between   '>
                        <button className="button-prev-image bg-gray-400 rounded-full">
                            <ChevronLeftIcon className='w-6 h-6 text-white' />
                        </button>
                        <button className="button-next-image bg-gray-400 rounded-full">
                            <ChevronRightIcon className='w-6 h-6 text-white' />
                        </button>
                    </div>
                </div>
            </div >
        ) : (
            <ImageCarousel image={images[0]} />
        )
    )
}

const ImageCarousel = ({ image }) => {
    return (
        <div >
            <img className='object-cover object-center w-full  max-w-3xl mx-auto rounded-lg' src={image.img} alt={image.alt} title={image.title} />
        </div>
    )
}

export default CarouselImages
