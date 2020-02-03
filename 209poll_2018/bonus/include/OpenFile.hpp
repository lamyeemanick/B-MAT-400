/*
** EPITECH PROJECT, 2019
** OOP_nanotekspice_2018
** File description:
** OpenFile
*/

#ifndef OPENFILE_HPP_
	#define OPENFILE_HPP_

#include <iostream>
#include <vector>
#include <fstream>

class OpenFile {
	public:
		OpenFile(const std::string &filepath);
		~OpenFile();

        const std::vector<std::string> getData() const { return (_data); };
        void readFile();
        void overwriteFile(std::vector<std::string> &content);
	protected:
	private:
        std::string _filepath;
        std::ifstream _ifile;
        std::ofstream _ofile;
        std::vector<std::string> _data;
};

#endif /* !FILE_HPP_ */
