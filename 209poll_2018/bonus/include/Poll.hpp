/*
** EPITECH PROJECT, 2019
** 209poll_2018
** File description:
** Poll
*/

#ifndef POLL_HPP_
#define POLL_HPP_

#include <vector>
#include <iostream>

class Poll {
	public:
		Poll();
		~Poll();

        void run();
        void openConcurrents(std::string const &data, std::string &file1, std::string &file2);

	protected:
	private:
        std::vector<std::string> _data;
        int _population;
        int _answers;
        double _p1;
        double _p2;
};

#endif /* !POLL_HPP_ */
