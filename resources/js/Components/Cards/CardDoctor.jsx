import { Link } from "@inertiajs/react";
import React from "react";

const CardDoctor = ({ doctor }) => {
    return (
        <div className=" max-w-md">
            <div className=" relative  overflow-hidden rounded-lg">
                <Link
                    href={route("doctor", doctor.slug)}
                    aria-label={doctor.name}
                    alt=""
                >
                    <img
                        src={doctor.thumb}
                        className="aspect-square w-full transform object-cover transition-transform duration-300 ease-out hover:scale-110"
                    />
                </Link>
            </div>
            <div className="mt-2">
                {doctor.specialty && (
                    <Link
                        href={route("specialty", doctor.specialty.slug)}
                        className="text-primary mt- block text-sm font-medium"
                    >
                        {doctor.specialty.name}
                    </Link>
                )}
                <Link href={route("doctor", doctor.slug)}>
                    <h3 className="text-xl font-semibold ">{doctor.name}</h3>
                </Link>

                {doctor.specialties && (
                    <div className="mt-1  ">
                        <span className=" text-primary text-sm font-semibold">
                            Especialista en:
                        </span>
                        <div className="flex flex-wrap gap-x-3 ">
                            {doctor.specialties.map((specialty) => (
                                <Link
                                    href={route("specialty", specialty.slug)}
                                    className=" text-base font-medium hover:text-primary-700"
                                >
                                    {specialty.name}
                                </Link>
                            ))}
                        </div>
                    </div>
                )}
                <span className="inline-block text-sm  text-neutral-400">
                    Trabajando desde {doctor.startYear}
                </span>
            </div>
        </div>
    );
};

export default CardDoctor;
