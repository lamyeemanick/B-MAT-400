/*
** EPITECH PROJECT, 2019
** CCP_plazza_2018
** File description:
** Explode
*/

#ifndef EXPLODE_HPP_
#define EXPLODE_HPP_

#include <vector>
#include <iostream>
#include <sstream>

class Explode {
	public:
		Explode() {};
		~Explode() {};

        static std::vector<std::string> explode(std::string const &s, char delim);

	protected:
	private:
};

#endif /* !EXPLODE_HPP_ */
