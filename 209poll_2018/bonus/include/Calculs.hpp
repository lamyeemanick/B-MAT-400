/*
** EPITECH PROJECT, 2019
** 209poll_2018
** File description:
** Calculs
*/

#ifndef CALCULS_HPP_
#define CALCULS_HPP_

#include <utility>

class Calculs {
	public:
		Calculs(int population, int pop, double percent);
		~Calculs();

        double getf95() { return (_f95); };
        double gets95() { return (_s95); };
        double getf99() { return (_f99); };
        double gets99() { return (_s99); };
        double getPercent() { return (_percent); };
	protected:
	private:
        double _percent;
        double _f95; 
        double _s95; 
        double _f99; 
        double _s99; 
};

#endif /* !CALCULS_HPP_ */
